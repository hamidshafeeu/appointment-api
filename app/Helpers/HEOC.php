<?php
namespace App\Helpers;

use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class HEOC {
    
    public function eligibleForAppointment($identifier)
    {
        return $this->verifyWithDhifaau($identifier) == true && $this->verifyWithOB($identifier) == true;
    }

    public function verifyWithDhifaau($identifier)
    {
        $resp = Http::withHeaders([
            'authorization' => config('services.dhifaau.token'),
        ])->get( config('services.dhifaau.url') . "/vaccinations/$identifier");

        if ( $resp->successful() ) {
            $vaccines = $resp->json();

            if( count($vaccines) ) {
                $c = collect($vaccines);
                return $c->filter(function($item) {
                    return Arr::get($item, 'dose.id') == 1;
                })->count() > 0 && $c->filter(function($item) {
                    return Arr::get($item, 'dose.id') == 2;
                })->count() == 0 ;
            }
            else {
                return true;
            }

        }

        throw new Exception("Could not look with dhifaau up!");
    }
    
    public function verifyWithOB($identifier)
    {
        $resp = Http::withHeaders([
            'authorization' => 'Bearer '. config('services.ob.token'),
        ])->get( config('services.ob.url') . "/Individual/Status/$identifier");

        if ( $resp->successful() ) {

            if( $vaccines = $resp->json() ) {
                return collect($vaccines)->filter(function($item) {
                    return Arr::get($item, 'state') != 'Positive';
                })->count() > 0;
            }

        }

        throw new Exception("Could not look with OB up!");
    }

}