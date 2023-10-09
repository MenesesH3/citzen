<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function bodyParameters()
    {
        return [
            'email' => [
                'description' => 'E-mail do usuário',
            ],
            'password' => [
                'description' => 'Senha do usuário',
            ]
        ];
    }

}
