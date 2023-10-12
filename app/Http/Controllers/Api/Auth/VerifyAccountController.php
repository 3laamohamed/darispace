<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SendCodeVerifyAccount;
use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Http\Request;
use Botble\Api\Http\Resources\UserResource;
use App\Enum\UserTypeEnum;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Illuminate\Support\Facades\Mail;
use Botble\RealEstate\Models\Account;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use ApiHelper;

class VerifyAccountController extends Controller
{

    public function sendCode(Request $request)
    {
        try {

            $validateUser = Validator::make(
                $request->all(),
                [
                    'phone' => 'required',
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $user =Account::firstWhere('phone', $request->phone);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'phone Not Found',
                    'errors' => 'you Have to Register'
                ], 401);
            }

            if ($user->phone_verified_at) {
                return response()->json([
                    'status' => false,
                    'message' => 'phone Address Is verified please Try to Login',
                ], 422);
            }

            // Delete all old code that user send before.
             ResetCodePassword::where('phone', $request->phone)->delete();

             // Generate random code
             $data['phone'] = $request->phone;
             $data['code'] = mt_rand(1000, 9999);
             $codeData = ResetCodePassword::create($data);
 
             sendMessage($request->phone,$data['code']);
             // Create a new code

            // Send phone to user
            // Mail::to($request->phone)->send(new SendCodeVerifyAccount($codeData->code));

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

    public function verifyAccount(Request $request,BaseHttpResponse $response)
    {
        try {

            $validateUser = Validator::make(
                $request->all(),
                [
                    'phone' => 'required',
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

            $user =Account::firstWhere('phone', $request->phone);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'phone Not Found',
                    'errors' => 'you Have to Register'
                ], 401);
            }

            if ($user->phone_verified_at) {
                return response()->json([
                    'status' => false,
                    'message' => 'phone Is verified please Try to Login',
                ], 422);
            }

            $codeChecked = $this->checkCode($request->phone, $request->code);
            if (!$codeChecked['status']) {
                return response()->json([
                    'status' => false,
                    'message' => $codeChecked['msg'],
                ], 422);
            }

            $user->phone_verified_at=now();
            $user->save();

           
            $token = $user->createToken($request->input('token_name', 'Personal Access Token'));

            return $response
                ->setData([
                    'token' => $token->plainTextToken,
                    'user' => new UserResource($user),
            ]);
            return response([
                "status" => true,
                'data'=>$resource,
                'access_token' => $user->createToken("API TOKEN")->plainTextToken,
                'message' => "Your Account Verified Success"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    private function checkCode($phone, $code)
    {
        $checkVerifyCode = ResetCodePassword::firstWhere(['code' => $code, 'phone' => $phone]);

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
