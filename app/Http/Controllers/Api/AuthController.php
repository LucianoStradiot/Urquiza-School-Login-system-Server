<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \App\Models\Student;

class AuthController extends Controller
{
    public function signup(SignUpRequest $request)
    {
        try {
            $data = $request->validated();

            $user = Student::create([
                'name' => $data['name'],
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
        $credentials = $request->validated();
        if (!Auth::attempt($credentials)) {
            return response([
                'message' => 'Email address or password is inconrrect'
            ]);
        }

        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        return response([
            'user' => $user,
            'token' => $token
        ]);

    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response('', 204);
    }
}
