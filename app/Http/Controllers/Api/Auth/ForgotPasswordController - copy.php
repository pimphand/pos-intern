<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResetPassword;
use App\Models\User;
use App\Notifications\MailResetPasswordNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function sendResetCodeResponse(Request $request)
    {
        $data = $request->only('email');

        $validator = Validator::make($data,[
            'email' => 'required|email|exists:users'
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Anda belum memasukkan email atau email tidak sesuai',
            ],403);
        }

        $data['token']  = mt_rand(1000, 9999);
        $data['deleted_at'] = Carbon::now()->addHours(1);

        ResetPassword::where('email', $request->email)->delete();

        $resetPassword = ResetPassword::create($data);        

        Notification::send($resetPassword, new MailResetPasswordNotification($resetPassword->token));

            return response()->json([
                'success'   => true,
                'message'   => 'Token reset password berhasil dikirim',
            ],200);

    }

    protected function checkToken(Request $request)
    {
        $data = $request->only('token');

        $validator = Validator::make($data,[
            'token' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Token tidak sesuai atau sudah expired'
            ],401);
        }

        $resetPassword = ResetPassword::firstWhere('token', $request->token);

        return response()->json([
            'success'   => true,
            'message'   => 'Token yang anda masukkan sesuai',
            'token'     => $resetPassword->token
        ],200);
    }


    protected function sendResetResponse(Request $request)
    {
        $input = $request->only('token','password', 'password_confirmation');

        $validator = Validator::make($input, [
            'token' => 'required',
            'password'  => 'required|confirmed|min:8',
        ]);

        if($validator->fails()){
            return response()->json([
                'success'   => false,
                'message'   => 'Data yang anda masukkan tidak sesuai',
            ],403);
        }

        $passwordReset = ResetPassword::firstWhere('token', $request->token);

        if($passwordReset->isExpire()){
            return response()->json([
                'message'   => 'Kode telah kadaluarsa'
            ]);
        }

        $user = User::firstWhere('email', $passwordReset->email);

        $response = Password::reset($input, function($user,$password){
                $user->forceFill([
                   'password' => Hash::make($password), 
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
        });

        if($response == Password::PASSWORD_RESET){
            return response()->json([
                'success'   => true,
                'message'   => 'Password berhasil direset'
            ], 200);
        } else {
            return response()->json([
                'success'   => false,
                'message'   => 'Data yang anda masukkan tidak sesuai'
            ],403);
        }
    }
}
