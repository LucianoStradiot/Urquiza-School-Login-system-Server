<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('email', 'exists:students,email', function ($input) {
            return $this->validateExists($input['email'], 'students');
        });

        $validator->sometimes('email', 'exists:super_admins,email', function ($input) {
            return !$this->validateExists($input['email'], 'students') && $this->validateExists($input['email'], 'super_admins');
        });
    }

    protected function validateExists($value, $table)
    {
        return \DB::table($table)->where('email', $value)->exists();
    }
}
