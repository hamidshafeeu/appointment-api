<?php

namespace App\Jobs;

use App\Helpers\HEOC;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessAppointment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public  Booking $booking;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $heoc = app(HEOC::class);
        if( $heoc->eligibleForAppointment($this->booking->identifier, $this->booking->name) ) {
            $this->booking->approve();
            dispatch(new SendSMS( 
                $this->booking->phone,  
                view('sms.appointment', [ 
                    'booking' => $this->booking,
                    'link' => $this->getSignedUrl()
                ])->render()
            ));
        }
        else {
            $this->booking->reject();
            dispatch(new SendSMS( 
                $this->booking->phone,  
                view('sms.rejection', [ 
                    'booking' => $this->booking
                ])->render()
            ));
        }
    }

    public function getSignedUrl()
    {
        return URL::signedRoute('booking.view', ['booking' => $this->booking->hash]);
    }
}
