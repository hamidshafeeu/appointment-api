<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __invoke()
    {
        publish(request()->merge(request()->auth->getPayload())->all());
        return response()->json([
            'message' => 'Appointment successfully requested.'
        ], 201);
    }
}
