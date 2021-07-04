<?php

namespace App\Http\Controllers;

use App\Helpers\OTPHelper;
use App\Http\Requests\BeginRequest;
use App\Jobs\SendSMS;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class AuthController extends Controller
{
    public function begin(BeginRequest $request, OTPHelper $otpHelper)
    {
        
        if( $otpHelper->sendOTP($request->get('phone')) ) {
            $token = token($request->except('otp'));
            return response()->json([
                'message' => 'An OTP has been sent!',
                'auth-token' => $token,
                'otp-verified' => false,
            ], 200);
        }
        return response()->json([
            'message' => 'Could not send an OTP! Please try again in a few.',
        ], 422);
    }

    public function otp_resend(OTPHelper $otpHelper)
    {
        if( $phone =  request()->auth->get('phone')) {
            if( $otpHelper->sendOTP($phone) ) {
                return response()->json([
                    'message' => 'An OTP has been sent!',
                    'otp-verified' => false,
                ], 200);
            }
        }

        return response()->json([
            'message' => 'Your session is not valid. Please start over.',
        ], 401);
    }

    public function otp(Request $request, OTPHelper $otpHelper)
    {
        try {
            if( $otpHelper->verify($request->get('otp')) ) {
                $otpHelper->clean($request->auth->get('phone'));
                return response()->json([
                    'message' => 'OTP verified!',
                    'token' => token($request->auth->getPayload() + ['otp-verified' => true]),
                    'otp-verified' => true,
                ], 200);
            }
        } catch (\Throwable $th) {
            response()->json([
                'message' => 'Invalid code!',
                'errors' => [
                    'otp' => [
                        $th->getMessage(),
                    ]
                ]
            ], 422);
        }


        return response()->json([
            'message' => 'Invalid code!',
            'errors' => [
                'otp' => [
                    'Invalid code or code must have expired.',
                ]
            ]
        ], 422);
    }
}
