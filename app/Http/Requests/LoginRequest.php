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
            'email' => ['required', 'email', 'regex:/^[A-Za-z]+@terciariourquiza\.edu\.ar$|^[0-9]+@terciariourquiza\.edu\.ar$/'],

            'password' => ['required', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)[A-Za-z\d]{8,}$/'],
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


    public function messages()
    {
        return [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Por favor, ingresa una dirección de correo electrónico válida.',
            'email.regex' => 'El correo electrónico ingresado no respeta el formato correcto.',
            'email.no_spaces' => 'El correo electrónico no puede contener espacios en blanco.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.regex' => 'La contraseña debe tener al menos 8 caracteres y contener al menos una letra mayúscula, una letra minúscula y un número.',
            'password.no_spaces' => 'La contraseña no puede contener espacios en blanco.',

        ];
    }



    protected function validateExists($value, $table)
    {
        return \DB::table($table)->where('email', $value)->exists();
    }
}

