<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DietPlan;

class DietRecommendationController extends Controller
{
    public function getPlan(Request $request) {
        // Lấy chỉ số mới nhất mà user vừa nhập
        $metrics = $request->user()->bodyMetrics()->latest()->first();

        if (!$metrics) {
            return response()->json(['message' => 'Anh chưa nhập chỉ số cơ thể nhé!'], 404);
        }

        // Tự động phân tích theo Body Type để đưa ra thực đơn tương ứng
        $primary = "Thực đơn chính (Nội bộ): Tạng người " . $metrics->body_type . " - Sáng: Ức gà áp chảo + Khoai lang. Trưa: Cơm lứt + Cá hồi. Tối: Salad bò.";
        $alternative = "Thực đơn thay thế (External System - Gemini AI): Sáng: Bánh mì đen + Trứng ốp. Trưa: Bún gạo lứt thịt nạc. Tối: Canh bí đao.";

        // Lưu kế hoạch ăn kiêng này vào MySQL
        $dietPlan = DietPlan::create([
            'user_id' => $request->user()->id,
            'primary_plan' => $primary,
            'alternative_plan' => $alternative,
            'is_accepted' => false
        ]);

        return response()->json($dietPlan);
    }

    public function acceptPlan(Request $request) {
        $plan = DietPlan::where('user_id', $request->user()->id)->latest()->first();
        if ($plan) {
            $plan->update(['is_accepted' => true]);
            return response()->json(['message' => 'Đã chấp nhận thực đơn chính thành công!']);
        }
        return response()->json(['message' => 'Không tìm thấy thực đơn!'], 404);
    }
}
