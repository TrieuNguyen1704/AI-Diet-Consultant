<?php

namespace App\Http\Controllers\AuthModule;
use App\Http\Controllers\Controller; // <-- QUAN TRỌNG: Thêm dòng này để kế thừa gốc
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
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
    public function forgotPassword(Request $request)
{
    try {
        // 1. Validate kiểm tra định dạng email gửi lên
        $request->validate([
            'email' => 'required|email'
        ]);

        // 2. Tìm xem email này có trong hệ thống không
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Email này không tồn tại trên hệ thống anh ơi!'
            ], 444); // Trả về mã lỗi tự định nghĩa hoặc 404
        }

        // 3. Tạo một mật khẩu ngẫu nhiên mới gồm 8 ký tự
        $newPassword = Str::random(8);

        // 4. Mã hóa và cập nhật mật khẩu mới vào Database cho User đó
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        // 5. Nội dung mail gửi đi dưới dạng chuỗi văn bản thuần (Raw Mail)
        $mailContent = "Chào khách hàng {$user->name},\n\n"
            . "Hệ thống AI Diet Consultant đã đặt lại mật khẩu của bạn theo yêu cầu.\n"
            . "Mật khẩu đăng nhập mới của bạn là: {$newPassword}\n\n"
            . "Sau khi đăng nhập thành công, bạn vui lòng vào cài đặt để đổi lại mật khẩu mới nhằm bảo mật thông tin nhé!";

        // 6. Kích hoạt Mail của Laravel bắn đi qua SMTP
        Mail::raw($mailContent, function ($message) use ($user) {
            $message->to($user->email)
                ->subject('🔑 [AI DIET CONSULTANT] - CẤP LẠI MẬT KHẨU MỚI');
        });

        return response()->json([
            'message' => 'Mật khẩu mới đã được gửi về Email của anh thành công!'
        ]);

    } catch (\Throwable $e) {
        logger()->error("Lỗi gửi mail: " . $e->getMessage());
        return response()->json([
            'message' => 'Hệ thống gặp sự cố không thể gửi mail lúc này.',
            'error' => $e->getMessage()
        ], 500);
    }
}
}
