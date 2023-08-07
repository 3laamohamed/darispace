<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendCodeVerifyAccount;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class VerifyAccountController extends Controller
{

    public function sendCode(Request $request)
    {
        try {

            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::firstWhere('email', $request->email);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email Not Found',
                    'errors' => 'you Have to Register'
                ], 401);
            }

            if ($user->email_verified_at) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email Address Is verified please Try to Login',
                ], 422);
            }

            // Delete all old code that user send before.
            ResetCodePassword::where('email', $request->email)->delete();

            // Generate random code
            $data['email'] = $request->email;
            $data['code'] = mt_rand(1000, 9999);

            // Create a new code
            $codeData = ResetCodePassword::create($data);

            // Send email to user
            Mail::to($request->email)->send(new SendCodeVerifyAccount($codeData->code));

            return response([
                "status" => true,
                'message' => "Code Sent"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function verifyAccount(Request $request)
    {
        try {

            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'code' => 'required|digits:4',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user = User::firstWhere('email', $request->email);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email Not Found',
                    'errors' => 'you Have to Register'
                ], 401);
            }

            if ($user->email_verified_at) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email Address Is verified please Try to Login',
                ], 422);
            }

            $codeChecked = $this->checkCode($request->email, $request->code);
            if (!$codeChecked['status']) {
                return response()->json([
                    'status' => false,
                    'message' => $codeChecked['msg'],
                ], 422);
            }

            User::where(['email' => $request->email])
                ->update([
                    'email_verified_at' => now(),
                    'step_completed'=>2
            ]);

            return response([
                "status" => true,
                'message' => "Your Account Verified Success"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    private function checkCode($email, $code)
    {
        $checkVerifyCode = ResetCodePassword::firstWhere(['code' => $code, 'email' => $email]);

        if (!$checkVerifyCode) {
            return ['status' => false, 'msg' => 'Code Is Invail'];
        }
        if ($checkVerifyCode->created_at > now()->addHour()) {
            $checkVerifyCode->delete();
            return ['status' => false, 'msg' => 'Code Is Expire'];
        }

        $checkVerifyCode->delete();
        return ['status' => true, 'msg' => ''];
    }
} //end class
