<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpStudentRequest;
use App\Http\Requests\SignUpSuperAdminRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \App\Models\Student;
use \App\Models\SuperAdmin;
use App\Http\Resources\StudentResource;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{

    public function signup(SignUpStudentRequest $request)
    {
        try {


            $data = $request->validated();
            $profilePhotoPath = null;

            if ($request->hasFile('profile_photo')) {
                $profilePhotoPath = $request->file('profile_photo')->storeOnCloudinary()->getPublicId();
            }

            $user = Student::create([
                'name' => $data['name'],
                'dni' => $data['dni'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'career' => $data['career'],
                'profile_photo' => $profilePhotoPath,
            ]);

            $token = $user->createToken('main')->plainTextToken;

            $userResource = new StudentResource($user);

            return response()->json([
                'user' => $userResource,
                'token' => $token
            ]);

        } catch (\Exception $e) {
            \Log::error($e);
            error_log($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function signupSuperAdmin(SignUpSuperAdminRequest $request)
    {
        try {
            $data = $request->validated();
            $user = SuperAdmin::create([
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'career' => $data['career'],
            ]);

            $token = $user->createToken('main')->plainTextToken;

            return response()->json([
                'user' => $user,
                'token' => $token
            ]);



        } catch (\Exception $e) {
            \Log::error($e);
            error_log($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = [
                'email' => $request->input('email'),
                'password' => $request->input('password'),
            ];

            $user = Student::where('email', $request->email)->first() ?? SuperAdmin::where('email', $request->email)->first();

            if (optional($user)->email !== $request->email) {
                return response()->json(['messageEmail' => 'Email incorrecto para la contraseña ingresada'], 422);
            }

            if (!password_verify($request->password, $user->password)) {
                return response()->json(['messagePassword' => 'Contraseña incorrecta para el email ingresado'], 422);
            }

            if ($user instanceof Student && !$user->approved) {
                return response()->json(['messageVerification' => 'Su cuenta aún no ha sido verificada. Por favor, revise su casilla de correo electrónico o comuníquese con la institución.'], 422);
            }

            Auth::login($user);
            $request->session()->regenerate();
            $token = $user->createToken('main')->plainTextToken;

            return response([
                'user' => $user,
                'token' => $token
            ]);

        } catch (\Exception $e) {
            \Log::error($e);
            error_log($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }



    public function logout(Request $request)
    {
        $student = $request->user();
        $student->currentAccessToken()->delete();
        return response('', 204);
    }
}
