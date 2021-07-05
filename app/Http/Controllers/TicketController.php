<?php

namespace App\Http\Controllers;

use App\Jobs\RaiseTicket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __invoke()
    {
        dispatch(new RaiseTicket(request('message')));
        return response()->json([
            'message' => 'We have received your ticket, we shall reach you shortly.'
        ], 200);
    }
}
