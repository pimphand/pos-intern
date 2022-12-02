<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function create(Request $request)
    {
        if ($request->key == config('services.madjou.key')) {
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => bcrypt($request->password),
            ]);

            $user->madjou()->create([
                "type" => $request->type,
                "status" => $request->status,
                "expired_at" => now()->addDay($request->expired_at),
            ]);

            if (!$user) {
                return [
                    'data'      => [
                        'message'   => 'User gagal di buat',
                    ]
                ];
            }
            $user->load('madjou');
            return [
                'data'      => [
                    'message'   => 'berhasil dibuat',
                    'user' => $user
                ]
            ];
        }
        return [
            'data'      => [
                'message'   => 'kode tidak ditemukan',
            ]
        ];
    }

    public function list(Request $request)
    {
        if ($request->key == config('services.madjou.key')) {
            $user = User::whereHas('madjou')->get();
            return [
                'data'      => [
                    'message'   => 'kode tidak ditemukan',
                    'user' => $user->load('madjou')
                ]
            ];
        }
        return [
            'data'      => [
                'message'   => 'kode tidak ditemukan',
            ]
        ];
    }
}
