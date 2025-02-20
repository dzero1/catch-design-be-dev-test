<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    /** 
     * Handle user login 
     * 
     * @param Request $request
     * @return JsonResponse
     * */
    public function login(Request $request) : JsonResponse
    {
        // validate user inputs here
        $loginUserData = $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:8'
        ]);

        // pick the user and check password
        $user = User::where('email',$loginUserData['email'])->first();
        if(!$user || !Hash::check($loginUserData['password'], $user->password)){

            // if failed, return error with 401
            return response()->json([
                'message' => 'Invalid Credentials'
            ], 401);
        }

        // if success, return the token

        // create token
        $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
        ]);
    }

    /** 
     * Handle user login 
     * 
     * @return JsonResponse
     * */
    public function logout(): JsonResponse
    {
        // clear the tokens
        auth()->user()->tokens()->delete();
    
        return response()->json([
          "message" => "logged out"
        ]);
    }
}
