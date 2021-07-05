<?php
namespace App\Helpers;

use App\Jobs\RaiseTicket;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class HEOC {
    
    public function eligibleForAppointment($identifier, $name)
    {
        return $this->verifyWithDhifaau($identifier, $name) == true && $this->verifyWithOB($identifier) == true;
    }

    public function raiseOBTicket($message)
    {
        $resp = Http::withHeaders([
            'authorization' => 'Bearer ' . config('services.nazi_api.token'),
        ])->post(config('services.nazi_api.url') . "/tickets", [
            "fullName" => '-',
            "contactNumber" => '-',
            "ticketTypeId" => 1,
            "stateId" => 1,
            "originTypeId" => 7,
            "priorityLevelId" => 1,
            "callSummary" => $message,
            "tagTypes" => [
                "09CD1B39-A323-43A7-BE05-08D93F8490A7"
            ]
        ]);

        if ( $resp->successful() ) {
            // $response = $resp->json();
            return true;
        }

        throw new Exception("Could not raise a ticket on OB!");
    }

    private function similar($name, $other) {
        return metaphone($name) == metaphone($other);
    }
    
    public function verifyWithDhifaau($identifier, $name)
    {
        $resp = Http::withHeaders([
            'authorization' => config('services.dhifaau.token'),
        ])->get( config('services.dhifaau.url') . "/vaccinations/$identifier");

        if ($resp->successful()) {
            $vaccines = $resp->json();

            if (count($vaccines)) {
                if ($this->similar($name, Arr::get($vaccines, '0.person.name'))) {
                    $c = collect($vaccines);
                    return $c->filter(function ($item) {
                        return Arr::get($item, 'dose.id') == 1;
                    })->count() > 0 && $c->filter(function ($item) {
                        return Arr::get($item, 'dose.id') == 2;
                    })->count() == 0 ;
                } else {
                    $his_name = Arr::get($vaccines, '0.person.name');
                    $contact = Arr::get($vaccines, '0.person.primary_contact');
                    dispatch(new RaiseTicket("Could not validate user details of `$his_name` [name provided for appointment is `$name`] ($identifier). His likely contact number is $contact"));
                    throw new Exception("Could not match your details");
                }
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