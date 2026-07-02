<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Tài khoản email thật của anh để test Quên mật khẩu
        User::create([
            'name' => 'Anh Quân',
            'email' => 'leetr2k1@gmail.com',
            'password' => Hash::make('12345678'), // Mật khẩu mặc định ban đầu
        ]);

        // 2. Tài khoản mẫu số 1
        User::create([
            'name' => 'Nguyễn Văn Đạt',
            'email' => 'vandat.diet@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        // 3. Tài khoản mẫu số 2
        User::create([
            'name' => 'Trần Thị Mai',
            'email' => 'maitran.test@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
