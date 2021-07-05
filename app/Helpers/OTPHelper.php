<?php
namespace App\Helpers;

use Exception;
use App\Jobs\SendSMS;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class OTPHelper {



    public function sendOTP($phone)
    {
        if( $this->eligible($phone) ) {
            $otp = rand(1000, 9999);
            $this->storeOTP($otp, $phone);
            dispatch(new SendSMS($phone, "Use {$otp} to proceed to make appointment."));

            Log::info("$otp sent to $phone");
            return $otp;
        } else {
            if($this->releaseIfAllowable($phone)) {
                return $this->sendOTP($phone);
            }

        }
        return ;
    }

    public function storeOTP($otp, $phone)
    {
        Redis::set($this->getIdentifier(), json_encode([
            'otp' => $otp,
            'ip' => request()->ip(),
            'at' => now(),
        ]));

        $this->audit($phone);
    }

    private function releaseIfAllowable($phone)
    {
        if( $info = $this->getCode($this->getIdentifier()) ) {
            if( Carbon::parse($info->at)->diffInMinutes() > 20) {
                $this->clean($phone);
                return true;
            }
        }
    }

    public function clean($phone)
    {
        Redis::set($phone.':count', 0);
    }

    private function audit($phone)
    {
        Redis::incr($phone.':count');
        Redis::set($phone.':last_at', now());
    }

    public function eligible($phone)
    {
        $count = Redis::get($phone.':count');

        if( $count > 6 ) {
            if( $last = Redis::get($phone.':last_at') ) {
                if(Carbon::parse($last)->diffInMinutes() > 10) {
                    Redis::set($phone.':count', 0);
                    return true;
                }
                else {
                    return false;
                }
            }
        }
        return true;
    }

    protected function getIdentifier()
    {
        if( $auth = request()->auth ) {
            return $auth->get('identifier');
        } elseif( request()->has('identifier') ) {
            return request()->get('identifier');
        }
    }

    public function verify($userCode, $identifier=null)
    {
        if( !$identifier ) {
            $identifier = $this->getIdentifier();
        }

        if( $code = $this->getCode($identifier) ) {
            // dd($this->getIdentifier(), $code, $this->isCodeValid($code), $code->otp, $userCode);
            // dd($this->getCode($identifier), $identifier, $this->isCodeValid($code), $code->otp , $userCode );
            if( $this->isCodeValid($code) && $code->otp == $userCode ) {
                return true;
            }
        } else {
            throw new Exception("OTP Code is not valid.");
        }
        return true;
    }

    private function getCode($identifier)
    {
        return Redis::exists($identifier) ? json_decode(Redis::get($identifier)) : null;
    }

    private function isCodeValid($data = [])
    {
        $data = collect($data);
        if( $data->has('at') ) {
            return Carbon::parse($data->get('at') )->diffInMinutes() <= 10;
        }
        
        throw new Exception("OTP has expired. Try again.");
    }
}