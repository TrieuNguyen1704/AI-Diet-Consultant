<?php

namespace App\Http\Controllers\DonationModule;
use App\Http\Controllers\Controller; // <-- QUAN TRỌNG: Thêm dòng này để kế thừa gốc
use Illuminate\Http\Request;
use App\Models\DonationRequest; // Gọi đúng Model cũ của anh
use Exception;

class DonationController extends Controller
{
    // 1. API kiểm tra kho máu thời gian thực (External System)
    public function checkAvailability() {
        $bloodStock = [
            ['type' => 'O', 'status' => '🌟 Sẵn sàng'],
            ['type' => 'A', 'status' => '⚠️ Đang khan hiếm'],
            ['type' => 'B', 'status' => '🌟 Sẵn sàng'],
            ['type' => 'AB', 'status' => '⚠️ Đang khan hiếm'],
        ];
        return response()->json($bloodStock);
    }

    // 2. API Đăng ký hiến máu
    public function registerDonation(Request $request) {
        try {
            $request->validate([
                'blood_type' => 'required|string',
                'donation_date' => 'required|date',
            ]);

            // Lưu vào đúng bảng donation_requests của anh
            $donation = DonationRequest::create([
                'user_id' => $request->user()->id,
                'blood_type' => $request->blood_type,
                'donation_date' => $request->donation_date,
                'status' => 'Pending'
            ]);

            return response()->json([
                'message' => "Đăng ký hiến máu nhóm " . $request->blood_type . " thành công vào ngày " . $request->donation_date . "!"
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Lỗi hệ thống khi đăng ký: ' . $e->getMessage()
            ], 500);
        }
    }
}
