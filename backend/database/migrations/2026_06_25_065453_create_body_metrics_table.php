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
        Schema::create('body_metrics', function (Blueprint $table) {
            $table->id();
            // Tạo khóa ngoại liên kết với bảng users (khi xóa user thì dữ liệu này tự xóa theo)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('body_type');       // Loại thể trạng (Ectomorph, Mesomorph, Endomorph...) [cite: 4, 13]
            $table->float('height');           // Chiều cao (cm) [cite: 4, 13]
            $table->float('weight');           // Cân nặng (kg) [cite: 4, 13]
            $table->string('working_hours');   // Chi tiết giờ làm việc / Vận động [cite: 4]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('body_metrics');
    }
};
