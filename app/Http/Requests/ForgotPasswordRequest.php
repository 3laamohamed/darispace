<?php

namespace App\Http\Requests;


class ForgotPasswordRequest  extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules=[];
        switch (request()->segment(count(request()->segments()))) {
            case 'forgot':
                $rules = [
                    'phone' => 'required|exists:re_id="widget_analytics_general",phone',
                ];
                break;

            case 'check':
                $rules = [
                    'code' => 'required|string|exists:reset_code_passwords',
                    'phone' => 'required|exists:re_accounts,phone',
                ];
                break;
            case 'reset':
                $rules = [
                    'code' => 'required|string|exists:reset_code_passwords',
                    'password' => 'required|string|min:6|confirmed',
                ];
        }

        return $rules;
    }
}
