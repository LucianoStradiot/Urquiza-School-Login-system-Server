<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpStudentRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \App\Models\Student;

class AuthController extends Controller
{

    public function signup(SignUpStudentRequest $request)
    {

        try {
            $data = $request->validated();
            $student = Student::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'career' => $data['career'],
            ]);

            $token = $student->createToken('main')->plainTextToken;

            return response()->json([
                'student' => $student,
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

            $student = Student::where('email', $request->email)->first();
            if (!$student) {
                return response()->json(['error' => 'Invalid credentials email'], 401);
            }
            if (!password_verify($request->password, $student->password)) {
                return response()->json(['error' => 'Invalid credentials password'], 401);
            }

            Auth::login($student);
            $request->session()->regenerate();
            $token = $student->createToken('main')->plainTextToken;

            return response([
                'student' => $student,
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
