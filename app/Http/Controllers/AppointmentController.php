<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;
use App\Jobs\ProcessAppointment;
use App\Models\Slot;

class AppointmentController extends Controller
{
    public function cancel(Booking $booking)
    {
        if( $booking->is_cancellable ) {
            if($booking->reject()) {
                return response()->json([
                    'message' => 'Your appointment is now cancelled.',
                ], 200);
            }
        }

        return response()->json([
            'message' => 'Your appointment is not cancellable.',
        ], 406);
    }

    public function store(BookingRequest $bookingRequest)
    {

        if( Booking::notRejected()->whereHas('slot', function($q) {
            return $q->notExpired();
        })->identifier($bookingRequest->auth->get('identifier'))->exists() ) {
            return response()->json([
                'message' => 'You already have a pending appointment.'
            ], 406);
        }
        
        if( Booking::identifier($bookingRequest->auth->get('identifier'))->approved()->exists() ) {
            return response()->json([
                'message' => 'You already have an approved appointment.'
            ], 406);
        }

        if($slot = Slot::find(request()->input('slot.id'))) {

            if(
                Booking::query()->notRejected()->slot(request()->input('slot.id'))->count() < $slot->allocations )
            {
                $data = $bookingRequest->merge($bookingRequest->auth->getPayload())->all();
                publish($data);
                // dd($data);
                $booking = Booking::create([
                    'slot_id' => request()->input('slot.id'),
                    'name' => request('name'),
                    'identifier' => request()->auth->get('identifier'),
                    'phone' => request()->auth->get('phone'),
                    'hash' => Str::random(32),
                ]);

                dispatch(new ProcessAppointment($booking));
                
                return response()->json([
                    'message' => 'Appointment requested. You\'ll get a message with details and QR code shortly on confirmation.'
                ], 201);
            }

            return response()->json([
                'message' => 'We are sorry but the slot just got fully booked. Please try another slot.',
            ], 422);
    
        }

        return response()->json([
            'message' => 'Request seems to be invalid. Please try again!',
        ], 422);

    }
}
