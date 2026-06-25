<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('diet_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->text('primary_plan');      // Kế hoạch ăn kiêng chính (Lưu dạng chuỗi hoặc JSON) [cite: 6, 15]
            $table->text('alternative_plan');  // Kế hoạch ăn kiêng thay thế [cite: 11]
            $table->boolean('is_accepted')->default(false); // Người dùng đã nhấn chấp nhận hay chưa [cite: 10]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diet_plans');
    }
};
