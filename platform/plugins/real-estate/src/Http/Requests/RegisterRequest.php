<?php

namespace Botble\RealEstate\Http\Requests;

use Botble\Support\Http\Requests\Request;

class RegisterRequest extends Request
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|max:120|min:2',
            'last_name' => 'required|max:120|min:2',
            'username' => 'required|max:60|min:2|unique:re_accounts,username',
            'phone' => 'required|max:60|min:2|unique:re_accounts,phone',
            'email' => 'required|max:60|min:6|email|unique:re_accounts',
            'password' => 'required|min:6|confirmed',
        ];
    }
}
