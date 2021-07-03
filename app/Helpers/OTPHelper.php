<?php
namespace App\Helpers;

use App\Jobs\SendSMS;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Redis;

class OTPHelper {



    public function sendOTP($phone)
    {
        if( $this->eligible($phone) ) {
            $otp = rand(1000, 9999);
            $this->storeOTP($otp, $phone);
            dispatch(new SendSMS($phone, "Use {$otp} to proceed to make appointment."));
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
                Redis::set($phone.':count', 0);
                return true;
            }
        }
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
        return request()->auth && request()->auth->get('identifier');
    }

    public function verify($userCode, $identifier=null)
    {
        if( !$identifier ) {
            $identifier = $this->getIdentifier();
        }
        if( $code = $this->getCode($identifier) ) {
            // dd($this->getCode($identifier), $identifier, $this->isCodeValid($code), $code->otp , $userCode );
            if( $this->isCodeValid($code) && $code->otp == $userCode ) {
                return true;
            }
            else {
                throw new Exception("OTP Code expired.");
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
        
        return false;
    }
}