<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Dhifaau
{
    private function url($url)
    {
        return config('services.dhifaau.url') . $url;
    }

    public function atolls()
    {
        // Cache::forget("atolls");
        return Cache::remember('atolls', 5, function () {
            $response = Http::withHeaders([
                'authorization' => config('services.dhifaau.token')
            ])->get($this->url('/vaccination/atolls'));

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception("Could not fetch atolls!");
        });
    }
    
    public function islands_per_atoll($islandId)
    {
        // Cache::forget("atoll:$islandId:islands");
        return Cache::remember("atoll:$islandId:islands", 5, function () use ($islandId) {
            $response = Http::withHeaders([
                'authorization' => config('services.dhifaau.token')
            ])->get($this->url("/vaccination/atoll/$islandId/islands"));

            if ($response->successful()) {
                return collect($response->json())->map(function ($item) {
                    return [
                        'id' => $item['id'],
                        'name' => $item['name'],
                    ];
                });
            }

            throw new \Exception("Could not fetch islands!");
        });
    }

    public function centers_per_island($islandId)
    {
        return Cache::remember("island:$islandId:centers", 5, function () use ($islandId) {
            $response = Http::withHeaders([
                'authorization' => config('services.dhifaau.token')
            ])->get($this->url("/vaccination/island/$islandId/centers"));

            if ($response->successful()) {
                return collect($response->json())->map(function ($item) {
                    return [
                        'id' => $item['id'],
                        'name' => $item['name'],
                    ];
                });
            }

            throw new \Exception("Could not fetch islands!");
        });
    }

    public function getOpenDates()
    {
        return [
            '2021-07-04',
            '2021-07-05',
            '2021-07-06',
            '2021-07-07',
            '2021-07-08',
        ];
    }
    
    public function getSlots()
    {
        return [
                [
                    'start' => '9:00',
                    'end' => '9:15',
                    'quota' => 72,
                    'occupied' => 2,
                    'reserved' => 10,
                    'available' => 60
                ],
                [
                    'start' => '9:15',
                    'end' => '9:30',
                    'quota' => 72,
                    'occupied' => 2,
                    'reserved' => 50,
                    'available' => 20
                ],
                [
                    'start' => '11:15',
                    'end' => '11:30',
                    'quota' => 82,
                    'occupied' => 12,
                    'reserved' => 50,
                    'available' => 20
                ],

        ];
    }
}
