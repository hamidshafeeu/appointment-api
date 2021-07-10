<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Jobs\SendSMS;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;
use STS\JWT\JWTFacade;

class HomeController extends Controller
{
    public function index()
    {
        $bookings = Booking::when(request('q'), fn($q, $term) =>  $q->where('identifier', $term)->orWhere('phone', $term) )->latest()->paginate();
        return view('admin.home', compact('bookings'));
    }
    
    public function resend()
    {
        if($booking = Booking::hash(request('hash'))->approved()->first()) {
            dispatch(new SendSMS( 
                $booking->phone,  
                view('sms.appointment', [ 
                    'booking' => $booking,
                    'link' => $this->getSignedUrl($booking)
                ])->render()
            ));
            Log::channel('bot')->info( __(':user resent the sms for the appointment for :name (:identifier) on :date from :start to :end at :venue.', $booking->getAttributes() + [
                'user' => auth()->user()->name,
                'date' => $booking->slot->date,
                'start' => $booking->slot->start,
                'end' => $booking->slot->end,
                'venue' => $booking->slot->center->name,
            ] ) );
            return back()->with('message', 'SMS re-scheduled');
        }

        Log::channel('bot')->info( __(':user attempted to resend the sms for the appointment for :name (:identifier) on :date from :start to :end at :venue but failed..', $booking->getAttributes() + [
            'user' => auth()->user()->name,
            'date' => $booking->slot->date,
            'start' => $booking->slot->start,
            'end' => $booking->slot->end,
            'venue' => $booking->slot->center->name,
        ] ) );
        return back()->with('message', 'Could not re-schedule.');
    }
    
    public function cancel()
    {
        if($booking = Booking::hash(request('hash'))->notRejected()->first()) {
            if($booking->cancel()) {
                Log::channel('bot')->info( __(':user rejected the appointment for :name (:identifier) on :date from :start to :end at :venue.', $booking->getAttributes() + [
                    'user' => auth()->user()->name,
                    'date' => $booking->slot->date,
                    'start' => $booking->slot->start,
                    'end' => $booking->slot->end,
                    'venue' => $booking->slot->center->name,
                ] ) );
                return back()->with('message', 'Booking rejected');
            }
        }

        Log::channel('bot')->info( __(':user tried rejecting the appointment for :name (:identifier) on :date from :start to :end at :venue but failed.', $booking->getAttributes() + [
            'user' => auth()->user()->name,
            'date' => $booking->slot->date,
            'start' => $booking->slot->start,
            'end' => $booking->slot->end,
            'venue' => $booking->slot->center->name,
        ] ) );

        return back()->with('message', 'Could not reject.');
    }
    
    public function getSignedUrl($booking)
    {
        return URL::signedRoute('booking.view', ['booking' => $booking->hash]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->redirectTo('/admin/auth')->withoutCookie(config('app.name').'_admin');
    }

    public function sendAuthLink()
    {
        $data = request()->validate(['phone' => ['required', 'regex:/^(7|9)[0-9]{6}$/']]);

        if($admins = config('app.admins') ) {
            $admins = explode(',', $admins);
            if( in_array($data['phone'], $admins) ) {
                $link = URL::temporarySignedRoute('admin.authenticate', now()->addMinutes(2), ['token' =>  token([
                    'identifier' => 'admin',
                    'phone' => $data['phone']
                ])]);
        
                $link = shortLink($link);
        
                dispatch(new SendSMS($data['phone'], "Use the link to authenticate $link"));
        
                return redirect()->back()->with('message', 'You must have received an SMS. Follow it.');
            }
        }

        return redirect()->back()->with('error', 'You are not allowed');

    }

    public function authenticate($token)
    {
        if ( request()->hasValidSignature()) {
            $jwt = JWTFacade::parse($token);
            try {
                if($jwt->validate('')) {
                    Log::channel('bot')->info( __(':user logged in :ip .', [
                        'user' => $jwt->get('phone'),
                        'ip' => request()->ip(),
                    ] ) );
                    return redirect()->to('/admin')->withCookie(cookie(
                        config('app.name').'_admin', $token, 15, null, null, true
                    ));
                }
            } catch (\Throwable $th) {
                
            }
        }


        return redirect()->to('/admin/auth')->with('error', 'Link is not valid.');
    }
   
    public function auth()
    {
        return view('admin.auth');
    }
}
