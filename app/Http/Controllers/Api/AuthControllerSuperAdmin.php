<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpSuperAdminRequest;
use Illuminate\Http\Request;
use \App\Models\SuperAdmin;

class AuthControllerSuperAdmin extends Controller
{
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




    public function logoutSuperAdmin(Request $request)
    {
        $superAdmin = $request->user();
        $superAdmin->currentAccessToken()->delete();
        return response('', 204);
    }
}
