<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name' => 'required|string|max:55',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()->numbers()
            ],
            'career' => 'required|in:AF,DS,ITI'
        ];
    }
}
