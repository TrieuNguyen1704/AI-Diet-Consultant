<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Exception;

class AuthenticationController extends Controller
{
    // API Đăng ký tài khoản thực tế
    public function register(Request $request) {
        try {
            // 1. Kiểm tra dữ liệu đầu vào xem có hợp lệ không
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users', // Email phải là duy nhất
                'password' => 'required|string|min:6',
            ]);

            // 2. Tạo User mới và mã hóa mật khẩu bằng Hash::make
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'message' => 'Chúc mừng anh đã đăng ký tài khoản thành công!'
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Đăng ký thất bại! Email này có thể đã được đăng ký trước đó rồi anh ơi.'
            ], 400);
        }
    }

    // API Đăng nhập cấp Token (Giữ nguyên như cũ)
    public function login(Request $request) {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Sai tài khoản hoặc mật khẩu rồi anh ơi!'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Đăng nhập thành công!',
            'token' => $token,
            'user' => $user
        ]);
    }
}
