<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietPlan extends Model
{
    use HasFactory;

    // Bắt buộc phải có dòng này để cho phép gán dữ liệu từ Controller vào DB
    protected $fillable = [
        'user_id',
        'primary_plan',
        'alternative_plan',
        'is_accepted'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
