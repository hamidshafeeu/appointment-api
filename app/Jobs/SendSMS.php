<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Facades\Log;

class SendSMS implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $message;
    public $phone;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($phone, $message)
    {
        $this->phone = $phone;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $token = config('services.sms.token');

        // dd(config('services.sms.endpoint'), $token);
        $resp = Http::withHeaders([
            'content-type' => 'application/json',
            'authorization' => "Bearer $token"
        ])->post(config('services.sms.endpoint'), [
            // TODO change to phone
            'phone' => $this->phone,
            'message' => $this->message,
        ]);

        if( $resp->successful() ) {
            Log::info("SMS sent");
            return 0;
        }
        else {
            // dd(json_encode([
            //     // TODO change to phone
            //     'phone' => $this->phone,
            //     'message' => $this->message,
            // ]));
            throw new \Exception("Could not send SMS. Try again...");
        }
    }
}
