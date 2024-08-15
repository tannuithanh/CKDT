<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Chèn user Admin
        DB::table('users')->insert([
            [
                'MSNV' => '9999',
                'FullName' => 'Administrator',
                'Pass' => Hash::make('123456'),
                'MailAddress' => 'rd-cntt@thaco.com.vn',
                'PositionDetail' => 'Chuyên viên quản lý phần mềm',
                'Division' => null,
                'IDPosition' => 9, // Thay đổi IDPosition phù hợp với dữ liệu trong bảng positions
                'IDDepartment' => 7, // Thay đổi IDDepartment phù hợp với dữ liệu trong bảng departments
                'Avatar' => 'avatar/ADMINISTRATOR.jpg',
                'Signature' => '',
                'Admin' => 1,
            ],
        ]);

        $path = storage_path('app/public/users.xlsx');

        // Đọc dữ liệu từ file Excel
        $data = Excel::toArray([], $path);

        // Mảng đầu tiên chứa dữ liệu từ sheet đầu tiên của file Excel
        $users = $data[0];

        // Bắt đầu từ hàng thứ 9
        for ($i = 8; $i < count($users); $i++) {
            $user = $users[$i];

            DB::table('users')->insert([
                'MSNV' => $user[1], // Cột B (MSNV)
                'FullName' => $user[2], // Cột C (Họ và tên)
                'Pass' => Hash::make('123456'), // Đặt một mật khẩu mặc định hoặc có thể từ một cột khác nếu có
                'MailAddress' => $user[3], // Cột D (Mail)
                'PositionDetail' => $user[5], // Cột F (PositionDetail)
                'Division' => null, // Để trống như bạn yêu cầu
                'IDPosition' => $user[4], // Cột E (Position)
                'IDDepartment' => $user[6], // Cột G (Department)
                'Avatar' => '', // Để trống như bạn yêu cầu
                'Signature' => '', // Để trống như bạn yêu cầu
                'Admin' => 0, // Mặc định là 0
            ]);
        }
    }
}
