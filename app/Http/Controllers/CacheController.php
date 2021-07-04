<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class CacheController extends Controller
{
    public function updateCenters()
    {
        
        collect(request()->all())->each(function($item) {
            Center::updateOrCreate(['id' => $item['id']], $item);
        });
        Redis::set('centers', json_encode(request()->all()));

        return response()->json([
            'message' => 'Centers updated',
        ]);
    }

    public function updateSlots()
    {
        $cacheKey =  request('date').':'.request('center_id');
        Redis::set($cacheKey, Slot::date(request('date'))->center(request('center_id'))->get());

        return response()->json([
            'message' => 'Cache updated',
        ]);
    }
}
