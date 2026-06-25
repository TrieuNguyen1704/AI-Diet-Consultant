<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyMetric extends Model
{
    use HasFactory;

    // Cho phép ghi dữ liệu hàng loạt vào các cột này
    protected $fillable = [
        'user_id',
        'body_type',
        'height',
        'weight',
        'working_hours',
    ];

    // Khai báo liên kết ngược lại với bảng User
    public function user() {
        return $this->belongsTo(User::class);
    }
}
