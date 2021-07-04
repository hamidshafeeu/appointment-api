<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\BookingRequest;

class AppointmentController extends Controller
{
    public function __invoke(BookingRequest $bookingRequest)
    {

        if( Booking::pending()->identifier($bookingRequest->auth->get('identifier'))->exists() ) {
            return response()->json([
                'message' => 'You already have a pending appointment.'
            ], 406);
        }

        $data = $bookingRequest->merge($bookingRequest->auth->getPayload())->all();
        publish($data);
        // dd($data);
        Booking::create([
            'slot_id' => request()->input('slot.id'),
            'name' => request('name'),
            'identifier' => request()->auth->get('identifier'),
            'hash' => Str::random(32),
        ]);
        
        return response()->json([
            'message' => 'Appointment successfully requested. We will get back to you shortly.'
        ], 201);
    }
}
