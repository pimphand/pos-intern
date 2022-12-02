<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        
         if (!Auth::attempt($request->only('email', 'password'))) {
           return response()->json([
                'message' => 'Unauthorized',
           ],401);
        }
        
        $request->user()->tokens()->delete();

        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('MyAppToken')->plainTextToken;
      
        return [
            'success'       => true,
            'message'       => 'Login berhasil',
            'token'         =>  $token,
            'token_type'    => 'bearer',
        ];
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'success'    => true,
            'message'    => 'Logout berhasil'
        ];
    }
}
