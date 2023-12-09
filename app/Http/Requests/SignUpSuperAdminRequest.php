<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class SignUpSuperAdminRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:super_admins,email',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()->numbers()
            ],
            'career' => 'required|in:SA'
        ];
    }
}
