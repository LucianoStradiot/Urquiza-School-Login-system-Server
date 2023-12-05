<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginSuperAdminRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:students,email',
            'password' => 'required'
        ];

    }
}
