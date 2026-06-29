<?php

use Illuminate\Support\Facades\Route;

// ========================================================
// ĐƯỜNG DẪN MỚI: ĐỒNG BỘ THEO CẤU TRÚC PHÂN HỆ MODULE-BASED
// ========================================================
use App\Http\Controllers\AuthModule\AuthenticationController;
use App\Http\Controllers\DietModule\MetricsProcessingController;
use App\Http\Controllers\DietModule\DietRecommendationController;
use App\Http\Controllers\DonationModule\DonationController; // Sửa lại đường dẫn module hiến máu

// --- CÁC ROUTE KHÔNG CẦN ĐĂNG NHẬP (AUTH PUBLIC) ---
Route::post('/register', [AuthenticationController::class, 'register']); // Đăng ký tài khoản
Route::post('/login', [AuthenticationController::class, 'login']);       // Đăng nhập hệ thống

// --- CÁC ROUTE BẮT BUỘC PHẢI ĐĂNG NHẬP (Bảo mật bằng Sanctum) ---
Route::middleware('auth:sanctum')->group(function () {

    // Phân hệ 1: Quản lý Chỉ số cơ thể & Sức khỏe (Thuộc DietModule)
    Route::post('/metrics', [MetricsProcessingController::class, 'store']);

    // Phân hệ 2: Khuyến nghị thực đơn từ Hệ thống & AI (Thuộc DietModule)
    Route::get('/diet-plan', [DietRecommendationController::class, 'getPlan']);
    Route::post('/diet-plan/accept', [DietRecommendationController::class, 'acceptPlan']);
    Route::get('/diet-plan/alternative', [DietRecommendationController::class, 'getAlternativePlan']);

    // Phân hệ 3: Quản lý Kho máu & Đặt lịch (Thuộc DonationModule)
    Route::get('/blood-availability', [DonationController::class, 'checkAvailability']);
    Route::post('/donate-blood', [DonationController::class, 'registerDonation']);
});
