<?php

namespace Botble\RealEstate\Http\Controllers;

use App\Http\Controllers\Controller;
use Botble\ACL\Traits\LogoutGuardTrait;
use Botble\ACL\Traits\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use RealEstateHelper;
use SeoHelper;
use Theme;
use URL;

class LoginController extends Controller
{
    use AuthenticatesUsers, LogoutGuardTrait {
        AuthenticatesUsers::attemptLogin as baseAttemptLogin;
    }

    public string $redirectTo = '/';

    public function __construct()
    {
        session(['url.intended' => URL::previous()]);
        $pages = [route('public.account.login'), route('public.single'), route('public.account.register')];

        if (in_array(session()->get('url.intended'), $pages)) {
            $this->redirectTo = route('public.account.dashboard');
        } else {
            $this->redirectTo = session()->get('url.intended');
        }
    }

    public function showLoginForm()
    {
        if (! RealEstateHelper::isRegisterEnabled()) {
            abort(404);
        }

        SeoHelper::setTitle(trans('plugins/real-estate::account.login'));

        if (view()->exists(Theme::getThemeNamespace() . '::views.real-estate.account.auth.login')) {
            return Theme::scope('real-estate.account.auth.login')->render();
        }

        return view('plugins/real-estate::account.auth.login');
    }

    protected function guard()
    {
        return auth('account');
    }

    public function login(Request $request)
    {
        // $request->email="+2".$request->email;
        if (! RealEstateHelper::isRegisterEnabled()) {
            abort(404);
        }

        $request->merge([$this->username() => '+2'.$request->input('email')]);
        // dd($request->all());

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse();
    }

    protected function attemptLogin(Request $request)
    {
        // dd('gggggggg');
        if ($this->guard()->validate($this->credentials($request))) {
            $account = $this->guard()->getLastAttempted();

            if (setting(
                'verify_account_email',
                false
            ) && empty($account->confirmed_at)) {
                throw ValidationException::withMessages([
                    'confirmation' => [
                        __('The given email address has not been confirmed. <a href=":resend_link">Resend confirmation link.</a>', [
                            'resend_link' => route('public.account.resend_confirmation', ['email' => $account->email]),
                        ]),
                    ],
                ]);
            }

            return $this->baseAttemptLogin($request);
        }

        return false;
    }

    public function username()
    {
        // dd(request()->all());
        return filter_var(request()->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
    }

    public function logout(Request $request)
    {
        if (! RealEstateHelper::isRegisterEnabled()) {
            abort(404);
        }

        $activeGuards = 0;
        $this->guard()->logout();

        foreach (config('auth.guards', []) as $guard => $guardConfig) {
            if ($guardConfig['driver'] !== 'session') {
                continue;
            }
            if ($this->isActiveGuard($request, $guard)) {
                $activeGuards++;
            }
        }

        if (! $activeGuards) {
            $request->session()->flush();
            $request->session()->regenerate();
        }

        return $this->loggedOut($request) ?: redirect('/');
    }
}
