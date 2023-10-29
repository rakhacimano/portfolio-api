<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|between:8,25|confirmed',
            'password_confirmation' => 'required|between:8,25',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(
                null,
                $validator->errors(),
                400
            );
        }

        $data = User::create($request->all());

        if ($data) {
            return ResponseFormatter::success(
                $data,
                'Register user berhasil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Register user gagal',
                500
            );
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return ResponseFormatter::error(
                    null,
                    'Token tidak valid',
                    400
                );
            }
        } catch (JWTException $e) {
            return ResponseFormatter::error(
                null,
                'Token gagal dibuat',
                500
            );
        }

        $data = [
            'token' => $token,
            'user' => JWTAuth::user(),
        ];

        return ResponseFormatter::success(
            $data,
            'Login berhasil'
        );
    }

    public function loginCheck()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return ResponseFormatter::error(
                    null,
                    'User tidak ditemukan',
                    404
                );
            }
        } catch (JWTException $e) {
            return ResponseFormatter::error(
                null,
                'Token tidak valid',
                400
            );
        }

        return ResponseFormatter::success(
            $user,
            'Token valid dan user ditemukan'
        );
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::parseToken());

            return ResponseFormatter::success(
                null,
                'Logout berhasil'
            );
        } catch (JWTException $e) {
            return ResponseFormatter::error(
                null,
                'Logout gagal',
                500
            );
        }
    }

    public function update(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user) {
            return ResponseFormatter::error(
                null,
                'User is not authenticated',
                401
            );
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string',
            // 'email' => 'string|unique:users|email',
        ]);

        if ($validator->fails()) {
            return ResponseFormatter::error(
                null,
                $validator->errors(),
                400
            );
        }

        $user->update($request->all());

        if ($user) {
            return ResponseFormatter::success(
                $user,
                'Profile berhasil diperbarui'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Profile gagal diperbarui',
                500
            );
        }
    }

    public function profile($id)
    {
        $user = User::find($id);

        if ($user) {
            return ResponseFormatter::success(
                $user,
                'Data user berhasil ditemukan'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data user tidak ada',
                404
            );
        }
    }

    public function index()
    {
        $data['count'] = User::count();

        if ($data['count'] > 0) {
            $data['users'] = User::get();
            return ResponseFormatter::success(
                $data,
                'Data user berhasil diambil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data user tidak ada',
                404
            );
        }
    }

    public function destroy(User $user, $id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return ResponseFormatter::success(
                null,
                'Data user berhasil dihapus'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data user tidak ada',
                404
            );
        }
    }
}
