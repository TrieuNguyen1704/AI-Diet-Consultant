<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\MetricsProcessingController;
use App\Http\Controllers\DietRecommendationController;
use App\Http\Controllers\DonationController;

// --- CÁC ROUTE KHÔNG CẦN ĐĂNG NHẬP ---
Route::post('/register', [AuthenticationController::class, 'register']); // Đăng ký tài khoản
Route::post('/login', [AuthenticationController::class, 'login']);       // Đăng nhập hệ thống

// --- CÁC ROUTE BẮT BUỘC PHẢI ĐĂNG NHẬP (Bảo mật bằng Sanctum) ---
Route::middleware('auth:sanctum')->group(function () {

    // Module 1: Xử lý chỉ số cơ thể
    Route::post('/metrics', [MetricsProcessingController::class, 'store']); // Nhập thông số chiều cao, cân nặng...

    // Module 2: Khuyến nghị thực đơn
    Route::get('/diet-plan', [DietRecommendationController::class, 'getPlan']); // Lấy thực đơn dựa trên chỉ số
    Route::post('/diet-plan/accept', [DietRecommendationController::class, 'acceptPlan']); // Người dùng duyệt thực đơn chính
    Route::get('/diet-plan/alternative', [DietRecommendationController::class, 'getAlternativePlan']); // Lấy thực đơn thay thế nếu từ chối món chính

    // Module 3: Quản lý hiến máu
    Route::get('/blood-availability', [DonationController::class, 'checkAvailability']); // Xem trạng thái/tính sẵn có của máu
    Route::post('/donate-blood', [DonationController::class, 'registerDonation']); // Đăng ký hiến máu
});
