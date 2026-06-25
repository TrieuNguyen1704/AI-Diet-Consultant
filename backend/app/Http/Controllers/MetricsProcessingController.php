<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BodyMetric;
use App\Models\DietPlan; // <-- Anh nhớ thêm dòng gọi Model này vào nhé
use Exception;

class MetricsProcessingController extends Controller
{
    public function store(Request $request) {
        try {
            if (!$request->has(['body_type', 'height', 'weight', 'working_hours'])) {
                return response()->json(['message' => 'Dữ liệu Frontend gửi lên bị thiếu trường rồi anh ơi!'], 400);
            }

            // 1. Lưu thông số vào bảng body_metrics
            $metric = BodyMetric::create([
                'user_id' => $request->user()->id,
                'body_type' => $request->body_type,
                'height' => $request->height,
                'weight' => $request->weight,
                'working_hours' => $request->working_hours,
            ]);

            // --- 2. LUỒNG TỰ ĐỘNG SINH THỰC ĐƠN NGAY KHI CÓ CHỈ SỐ ---
            $primary = "Thực đơn chính (Hệ thống tính): Tạng người " . $request->body_type . " - Sáng: Ức gà áp chảo + Khoai lang. Trưa: Cơm lứt + Cá hồi. Tối: Salad bò.";
            $alternative = "Thực đơn thay thế (External System - Gemini AI): Sáng: Bánh mì đen + Trứng ốp. Trưa: Bún gạo lứt thịt nạc. Tối: Canh bí đao.";

            DietPlan::create([
                'user_id' => $request->user()->id,
                'primary_plan' => $primary,
                'alternative_plan' => $alternative,
                'is_accepted' => false
            ]);
            // --------------------------------------------------------

            return response()->json([
                'message' => 'Đã lưu chỉ số cơ thể và tạo thực đơn thành công vào Database!',
                'data' => $metric
            ]);

        } catch (Exception $e) {
            return response()->json([
                'message' => 'Lỗi nội bộ Backend: ' . $e->getMessage()
            ], 500);
        }
    }
}
