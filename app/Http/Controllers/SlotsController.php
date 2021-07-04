<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use Illuminate\Http\Request;

class SlotsController extends Controller
{
    public function __invoke()
    {
        collect(request('slots'))->each(function($slot) {
            Slot::updateOrCreate([
                'center_id' => $slot['center_id'],
                'date' => $slot['date'],
            ], $slot);
        });

        return response()->json([
            'message' => 'Slots created',
        ]);
    }
}
