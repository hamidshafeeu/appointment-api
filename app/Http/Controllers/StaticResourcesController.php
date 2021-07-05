<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Booking;
use App\Helpers\Dhifaau;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class StaticResourcesController extends Controller
{
    public function atolls(Dhifaau $dhifaau)
    {
        return $dhifaau->atolls();
    }
    
    public function atoll_islands($id, Dhifaau $dhifaau)
    {
        return $dhifaau->islands_per_atoll($id);
    }
    
    public function island_centers($id, Dhifaau $dhifaau)
    {
        return $dhifaau->centers_per_island($id);
    }
    
    public function center_dates($id, Dhifaau $dhifaau)
    {
        return array_values(Slot::has('active_bookings', '=', DB::raw('allocations'))->whereRaw('date', '>=', now())->get()->pluck('date')->unique()->sort()->toArray());
    }
    
    public function center_date_slots($id, $date)
    {
        return Slot::withCount('active_bookings')->site($id)->date($date)->get();
        // return Redis::get( $date.':'.$id);
    }

    public function centers()
    {
        return response()->json(
            json_decode(Redis::get('centers'))
        );
    }

    public function mine()
    {
        $identifier = request()->auth->get('identifier');
        return Booking::with('slot.center')->identifier( $identifier )->get();
    }
}
