<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginSuperAdminRequest;
use App\Http\Requests\SignUpSuperAdminRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \App\Models\SuperAdmin;

class AuthControllerSuperAdmin extends Controller
{
    public function signupSuperAdmin(SignUpSuperAdminRequest $request)
    {
        try {
            $data = $request->validated();
            $superAdmin = SuperAdmin::create([

                'email' => $data['email'],
                'password' => bcrypt($data['password']),
                'career' => $data['career'],
            ]);

            $token = $superAdmin->createToken('main')->plainTextToken;

            return response()->json([
                'superAdmin' => $superAdmin,
                'token' => $token
            ]);



        } catch (\Exception $e) {
            \Log::error($e);
            error_log($e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function loginSuperAdmin(LoginSuperAdminRequest $request)
    {
        try {
            $credentials = $request->validated();
            if (!Auth::attempt($credentials)) {
                return response([
                    'message' => 'Email address or password is inconrrect'
                ], 422);
            }

            $superAdmin = Auth::user();
            $token = $superAdmin->createToken('main')->plainTextToken;

            return response([
                'superAdmin' => $superAdmin,
                'token' => $token
            ]);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function logoutSuperAdmin(Request $request)
    {
        $superAdmin = $request->user();
        $superAdmin->currentAccessToken()->delete();
        return response('', 204);
    }
}
