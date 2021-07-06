<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\Booking;
use App\Helpers\Dhifaau;
use App\Models\Center;
use Illuminate\Support\Facades\Cache;

class StaticResourcesController extends Controller
{
    public function atolls(Dhifaau $dhifaau)
    {
        return Cache::remember("atolls", 5*60, function () use ($dhifaau) {
            return $dhifaau->atolls();
        });
    }
    
    public function atoll_islands($id, Dhifaau $dhifaau)
    {
        return Cache::remember("islands:$id", 5*60, function () use ($id, $dhifaau) {
            return $dhifaau->islands_per_atoll($id);
        });
    }
    
    public function island_centers($id, Dhifaau $dhifaau)
    {
        return Cache::remember("centers:$id", 5*60, function () use ($id, $dhifaau) {
            return $dhifaau->centers_per_island($id);
        });
    }
    
    public function center_dates($id)
    {
        return Cache::remember("dates:$id", 5*60, function () use ($id) {
            return array_values(Slot::vacant()
                ->when($id, function($q, $id) {
                    return $q->site($id);
                })
                ->where('date', '>=', now())
                ->get()
                ->pluck('date')
                ->unique()
                ->sort()
                ->toArray()
            );
        });
    }
    
    public function center_date_slots($id, $date)
    {
        return Slot::withCount('active_bookings')
            ->notExpired()
            ->vacant()
            ->site($id)
            ->date($date)
            ->get();
    }

    public function centers()
    {
        return Cache::remember('centers', 5*60, function () {
            return Center::select(['id', 'name'])->get();
        });
    }

    public function mine()
    {
        $identifier = request()->auth->get('identifier');
        $phone = request()->auth->get('phone');
        return Booking::with('slot.center')
            ->phone($phone)
            ->identifier( $identifier )
            ->get();
    }
}
