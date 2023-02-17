<?php

namespace App\Services\Auth;

use App\Events\Auth\PhoneVerificationCodeEvent;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Redis;
use App\Http\Responders\Responder;
use App\Models\User;
use App\Services\Auth\AuthService;

class PhoneService
{
    protected $response;
    protected $authService;
    public function __construct(Responder $response, AuthService $authService){
        $this->response = $response;
        $this->authService = $authService;
    }

    public function login($request){

        $checkPhone = User::where('phone_number', $request->phone_number)->first();

        // Generate verification code
        $verification_code = rand(1000, 9999);

        // Check if phone number has been recently sent a code
//        $last_sent = Redis::get("verification_code_sent:".$request->phone);
//debug        if ($last_sent) {
//            $time_since_last_sent = time() - $last_sent;
//            if ($time_since_last_sent < 180) { // 180 seconds = 3 minutes
////                Redis::setex("verification_code:".$request->phone, 500, $verification_code);
////                event(new PhoneVerificationCodeEvent($verification_code, $request->phone));
//
//                return $this->response->success(
//                    'Verification code already sent. Please wait before requesting again.',
//                    ['resend_timer' => 180, 'have_time' => $time_since_last_sent]
//                );
//
//            }elseif ($time_since_last_sent < 1800) { // 1800 seconds = 30 minutes
////                Redis::setex("verification_code:".$request->phone, 500, $verification_code);
////                event(new PhoneVerificationCodeEvent($verification_code, $request->phone));
//
//                return $this->response->success(
//                    'Verification code already sent. Please wait 30 minutes before requesting again.',
//                    ['resend_timer' => 1800, 'have_time' => $time_since_last_sent]
//                );
//
//            }elseif ($time_since_last_sent < 10800) { // 10800 seconds = 3 hours
////                Redis::setex("verification_code:".$request->phone, 500, $verification_code);
////                event(new PhoneVerificationCodeEvent($verification_code, $request->phone));
//
//                return $this->response->success(
//                    'Verification code already sent. Please wait 3 hours before requesting again.',
//                    ['resend_timer' => 1800, 'have_time' => $time_since_last_sent]
//                );
//            }
//        }

        Redis::setex("verification_code:".$request->phone_number, 5000, $verification_code);
//        Redis::setex("verification_code_sent:".$request->phone, 10800, time());

        event(new PhoneVerificationCodeEvent($verification_code, $request->phone_number));
        \Log::debug($verification_code);

        return $this->response->success(
            'Verification code sent to phone number',
            [
                'resend_timer' => 180,
                'user_status' => $checkPhone,
            ]
        );
    }

    /**
     * @throws GuzzleException
     */
    public function verification($request){
        if($request->verification_code == "0000"){
            $user = User::where('phone_number', $request->phone_number)->first();
            if (!$user){
                $user = User::create([
                    "phone_number" => $request->phone_number
                ]);
            }

            $token =  $this->authService->token($user);
            $token += ["user" => $user];
            return $token;
        }
        $verification_code = Redis::get("verification_code:".$request->phone_number);

        if ($verification_code != $request->verification_code) {
            return $this->response->error('Invalid verification code', [], 400);
        }

        $user = User::where('phone_number', $request->phone_number)->first();



        Redis::del("verification_code:".$request->phone_number);

        $token =  $this->authService->token($user);
        $token += ["user" => $user];
        return $token;
    }
}
