<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use App\Mail\SendCodeResetPassword;
use App\Models\ResetCodePassword;
use App\Models\User;
use Botble\RealEstate\Models\Account;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function forgot(ForgotPasswordRequest $request)
    {
        try {

            // Delete all old code that user send before.
            ResetCodePassword::where('phone', $request->phone)->delete();

            // Generate random code
            $data['phone'] = $request->phone;
            $data['code'] = mt_rand(1000, 9999);

            sendMessage($request->phone,$data['code']);
            // Create a new code
            $codeData = ResetCodePassword::create($data);

            // Send phone to user
            // Mail::to($request->phone)->send(new SendCodeResetPassword($codeData->code));

            return response([
                "status"=>true,
                // "code"=>$data['code'],
                'message' => trans('passwords.sentPhone')
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }//end forgot method

    public function checkCode(ForgotPasswordRequest $request)
    {
        try {
            // find the code
            $passwordReset = ResetCodePassword::where('phone',$request->phone)->firstWhere('code', $request->code);

            // check if it does not expired: the time is one hour
            if ($passwordReset->created_at > now()->addHour()) {
                $passwordReset->delete();
                return response([
                    "status"=>false,
                    'message' => trans('passwords.code_is_expire')
                ], 422);
            }

            return response([
                "status"=>true,
                'code' => $passwordReset->code,
                'message' => trans('passwords.code_is_valid')
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }//end check method

    public function resetPassword(ForgotPasswordRequest $request)
    {
        try {
            // find the code
            $passwordReset = ResetCodePassword::firstWhere('code', $request->code);

            // check if it does not expired: the time is one hour
            if ($passwordReset->created_at > now()->addHour()) {
                $passwordReset->delete();
                return response(['message' => trans('passwords.code_is_expire')], 422);
            }

            // find user's phone
            $user = Account::firstWhere('phone', $passwordReset->phone);

            // update user password
            $user->password = isset($request->password) ? bcrypt($request->password) : $user->password;
            $user->save();
            // delete current code
            $passwordReset->delete();

            return response([
                'status' => true,
                'message' =>'password has been successfully reset'
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }// end reset password method

} //end class
