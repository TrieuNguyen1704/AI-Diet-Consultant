<?php

namespace App\Http\Controllers\DietModule;

use App\Http\Controllers\Controller; // <-- QUAN TRỌNG: Thêm dòng này để kế thừa gốc
use Illuminate\Http\Request;
use App\Models\DietPlan;
use App\Models\BodyMetric;
use Illuminate\Support\Facades\Http;
use Exception;

class DietRecommendationController extends Controller
{
    public function getPlan(Request $request)
    {
        // Lấy thực đơn mới nhất của User đang đăng nhập
        $plan = DietPlan::where('user_id', $request->user()->id)
            ->latest()
            ->first();

        if (!$plan) {
            return response()->json([
                'primary_plan' => 'Bạn chưa nhập chỉ số cơ thể để hệ thống tính toán.',
                'alternative_plan' => 'Chưa có thực đơn AI.'
            ]);
        }

        // Trả về dữ liệu thật lưu trong Database
        return response()->json([
            'primary_plan' => $plan->primary_plan,
            'alternative_plan' => $plan->alternative_plan // <-- Chính là chuỗi thực đơn thật từ Gemini
        ]);
    }

    public function acceptPlan(Request $request)
    {
        $plan = DietPlan::where('user_id', $request->user()->id)->latest()->first();
        if ($plan) {
            $plan->update(['is_accepted' => true]);
            return response()->json(['message' => 'Đã chấp nhận thực đơn chính thành công!']);
        }
        return response()->json(['message' => 'Không tìm thấy thực đơn!'], 404);
    }
    public function getAlternativePlan(Request $request)
    {
        try {
            $userId = $request->user()->id;

            // Lấy chỉ số cơ thể mới nhất
            $metric = BodyMetric::where('user_id', $userId)
                ->latest()
                ->first();

            if (!$metric) {
                return response()->json([
                    'message' => 'Anh chưa có chỉ số cơ thể để AI đổi món!'
                ], 400);
            }

            $apiKey = env('GEMINI_API_KEY');

            if (!$apiKey) {
                return response()->json([
                    'message' => 'Chưa cấu hình GEMINI_API_KEY trong file .env'
                ], 500);
            }

            $prompt = "
        Tôi có:
        - Tạng người: {$metric->body_type}
        - Chiều cao: {$metric->height} cm
        - Cân nặng: {$metric->weight} kg

        Hãy tạo cho tôi một thực đơn hoàn toàn mới.

        Yêu cầu:
        - 3 bữa: Sáng, Trưa, Tối
        - Khác với thực đơn thông thường như ức gà, cơm lứt
        - Ngắn gọn
        - Trả lời bằng tiếng Việt.
        ";

            $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

            $response = Http::timeout(60)
                ->acceptJson()
                ->post($url, [
                    "contents" => [
                        [
                            "parts" => [
                                [
                                    "text" => $prompt
                                ]
                            ]
                        ]
                    ]
                ]);

            // Ghi log để debug
            logger()->info("Gemini Status: " . $response->status());
            logger()->info("Gemini Response: " . $response->body());

            if (!$response->successful()) {

                return response()->json([
                    'message' => 'Google API Error',
                    'status' => $response->status(),
                    'error' => $response->json()
                ], $response->status());
            }

            $result = $response->json();

            $newAlternative =
                $result['candidates'][0]['content']['parts'][0]['text']
                ?? "AI không trả về dữ liệu.";

            // Cập nhật database
            $plan = DietPlan::where('user_id', $userId)
                ->latest()
                ->first();

            if ($plan) {
                $plan->update([
                    'alternative_plan' => $newAlternative
                ]);
            }

            return response()->json([
                'alternative_plan' => $newAlternative
            ]);
        } catch (\Throwable $e) {

            logger()->error($e);

            return response()->json([
                'message' => 'Lỗi hệ thống',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
