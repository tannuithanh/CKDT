<?php

// database/seeders/PositionsTableSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert([
            ['NamePosition' => 'Tổng giám đốc'],
            ['NamePosition' => 'Phó tổng giám đốc'],
            ['NamePosition' => 'GĐ xưởng sản xuất'],
            ['NamePosition' => 'GĐ khối thiết kế'],
            ['NamePosition' => 'PGĐ Mô phỏng & Thử nghiệm'],
            ['NamePosition' => 'Trưởng phòng'],
            ['NamePosition' => 'Phó phòng'],
            ['NamePosition' => 'Trưởng bộ phận'],
            ['NamePosition' => 'Trưởng nhóm'],
            ['NamePosition' => 'Chuyên viên'],
            ['NamePosition' => 'Nhân viên'],
            ['NamePosition' => 'Công nhân'],
            ['NamePosition' => 'Bảo vệ'],
            ['NamePosition' => 'Hành chính phòng ban'],
            ['NamePosition' => 'Hành chính trung tâm'],
            ['NamePosition' => 'Nhân sự'],
            ['NamePosition' => 'PGĐ Thiết kế kiểu dáng'],
        ]);
    }
}
