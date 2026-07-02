<?php

namespace App\Http\Controllers\DietModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BodyMetric;
use App\Models\DietPlan;
use Illuminate\Support\Facades\Http;

class MetricsProcessingController extends Controller
{
    public function store(Request $request)
    {
        try {

            if (!$request->has([
                'body_type',
                'height',
                'weight',
                'working_hours'
            ])) {

                return response()->json([
                    'message' => 'Thiếu dữ liệu gửi lên.'
                ], 400);
            }

            // Lưu thông số cơ thể
            $metric = BodyMetric::create([
                'user_id' => $request->user()->id,
                'body_type' => $request->body_type,
                'height' => $request->height,
                'weight' => $request->weight,
                'working_hours' => $request->working_hours,
            ]);

            $apiKey = env('GEMINI_API_KEY');

            if (!$apiKey) {
                return response()->json([
                    'message' => 'Chưa cấu hình GEMINI_API_KEY.'
                ], 500);
            }

            $prompt = "
            Tôi có:

            - Tạng người: {$request->body_type}
            - Chiều cao: {$request->height} cm
            - Cân nặng: {$request->weight} kg
            - Thời gian làm việc: {$request->working_hours} giờ/ngày

            Hãy xây dựng cho tôi một thực đơn lành mạnh.

            Yêu cầu:

            - 3 bữa: Sáng, Trưa, Tối.
            - Ngắn gọn.
            - Trả lời bằng tiếng Việt.
            - Chỉ ghi thực đơn, không giải thích.
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

            logger()->info("Gemini Status: " . $response->status());
            logger()->info("Gemini Response: " . $response->body());

            if ($response->successful()) {

                $result = $response->json();

                $alternative =
                    $result['candidates'][0]['content']['parts'][0]['text']
                    ?? "AI không trả về thực đơn.";

            } else {

                $alternative = "AI hiện đang bận, vui lòng thử lại sau.";

                logger()->error($response->body());
            }

            $primary = "Thực đơn chính:\n"
                . "Sáng: Ức gà + Khoai lang\n"
                . "Trưa: Cơm gạo lứt + Cá hồi\n"
                . "Tối: Salad bò";

            DietPlan::create([
                'user_id' => $request->user()->id,
                'primary_plan' => $primary,
                'alternative_plan' => $alternative,
                'is_accepted' => false
            ]);

            return response()->json([
                'message' => 'Đã lưu thông số và tạo thực đơn thành công.',
                'data' => $metric
            ]);

        } catch (\Throwable $e) {

            logger()->error($e);

            return response()->json([
                'message' => 'Lỗi hệ thống.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
