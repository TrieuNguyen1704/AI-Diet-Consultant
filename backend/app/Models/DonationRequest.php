<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationRequest extends Model
{
    use HasFactory;

    // Chỉ định chính xác tên bảng cũ của anh
    protected $table = 'donation_requests';

    // Cho phép lưu các trường này từ Frontend bắn sang
    protected $fillable = [
        'user_id',
        'blood_type',
        'donation_date',
        'status'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
