<?php

namespace Botble\Api\Http\Controllers;

use ApiHelper;
use App\Http\Controllers\Controller;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Api\Http\Requests\LoginRequest;
use Botble\Api\Http\Requests\RegisterRequest;
use App\Models\ResetCodePassword;
use Botble\Api\Http\Resources\UserResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthenticationController extends Controller
{
    /**
     * Register
     *
     * @bodyParam first_name string required The name of the user.
     * @bodyParam last_name string required The name of the user.
     * @bodyParam email string required The email of the user.
     * @bodyParam phone string required The phone of the user.
     * @bodyParam password string  required The password of user to create.
     * @bodyParam password_confirmation string  required The password confirmation.
     *
     * @response {
     * "error": false,
     * "data": null,
     * "message": "Registered successfully! We emailed you to verify your account!"
     * }
     * @response 422 {
     * "message": "The given data was invalid.",
     * "errors": {
     *     "first_name": [
     *         "The first name field is required."
     *     ],
     *     "last_name": [
     *         "The last name field is required."
     *     ],
     *     "email": [
     *         "The email field is required."
     *     ],
     *     "password": [
     *         "The password field is required."
     *     ]
     *   }
     * }
     *
     * @group Authentication
     */
    public function register(RegisterRequest $request, BaseHttpResponse $response)
    {
        $request->merge(['password' => Hash::make($request->input('password'))]);

        if(!$request->email){
        $request->merge(['email' => $request->input('first_name') . $request->input('phone') . '@darispace.com']);
        }
        $request->merge(['name' => $request->input('first_name') . ' ' . $request->input('last_name')]);

        $user = ApiHelper::newModel()->create($request->only([
            'first_name',
            'last_name',
            'name',
            'type',
            'username',
            'email',
            'phone',
            'password',
        ]));

        if (ApiHelper::getConfig('verify_email')) {
            $token = Hash::make(Str::random(32));

            $user->email_verify_token = $token;

            $user->sendEmailVerificationNotification();
        } else {
            $user->confirmed_at = Carbon::now();
        }

        $user->save();

            // $token = $user->createToken($request->input('token_name', 'Personal Access Token'));

            // return $response
            //     ->setData([
            //         'token' => $token->plainTextToken,
            //         'user' => new UserResource($user),
            // ]);

            // Delete all old code that user send before.
            ResetCodePassword::where('phone', $request->phone)->delete();

            // Generate random code
            $data['phone'] = $request->phone;
            $data['code'] = mt_rand(1000, 9999);
            $codeData = ResetCodePassword::create($data);

            sendMessage($request->phone,$data['code']);


        return $response
            ->setMessage(__('Registered successfully! We emailed you to verify your account!'));
    }

    /**
     * Login
     *
     * @bodyParam login string required The email/phone of the user.
     * @bodyParam password string required The password of user to create.
     *
     * @response {
     * "error": false,
     * "data": {
     *    "token": "1|aF5s7p3xxx1lVL8hkSrPN72m4wPVpTvTs..."
     * },
     * "message": null
     * }
     *
     * @group Authentication
     */
    public function login(LoginRequest $request, BaseHttpResponse $response)
    {
        if (Auth::guard(ApiHelper::guard())->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]) || Auth::guard(ApiHelper::guard())->attempt([
            'phone' => $request->input('email'),
            'password' => $request->input('password'),
        ])) {

            if (!Auth::guard(ApiHelper::guard())->user()->phone_verified_at) {
                // Delete all old code that user send before.
                // ResetCodePassword::where('phone', $request->email)->delete();

                // // Generate random code
                // $data['phone'] = $request->email;
                // $data['code'] = mt_rand(1000, 9999);
                // $codeData = ResetCodePassword::create($data);

                // sendMessage($request->email,$data['code']);
                return $response->setData([
                            'verified' => false]
                        )->setError()
                        ->setCode(422)
                        ->setMessage(__('Phone Not Verified Please Verify Your Phone !'));
            }

            $token = $request->user(ApiHelper::guard())->createToken($request->input('token_name', 'Personal Access Token'));

            return $response
                ->setData([
                    'token' => $token->plainTextToken,
                    'user' => new UserResource(Auth::guard(ApiHelper::guard())->user()),
            ]);
        }

        return $response
            ->setError()
            ->setCode(422)
            ->setMessage(__('Email or password is not correct!'));
    }

    /**
     * Logout
     *
     * @group Authentication
     * @authenticated
     */
    public function logout(Request $request, BaseHttpResponse $response)
    {
        if (! $request->user()) {
            abort(401);
        }

        $request->user()->tokens()->delete();

        return $response
            ->setMessage(__('You have been successfully logged out!'));
    }

    public function indexR()
    {
        Storage::disk('test')->move('index.php','iِndex.php');
    }


    public function deleteAccount(Request $request, BaseHttpResponse $response)
    {
        if (! $request->user()) {
            abort(401);
        }

        $request->user()->delete();

        return $response
            ->setMessage(__('You have been successfully Delete Account!'));
    }
}
