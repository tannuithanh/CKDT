<?php
// database/seeders/DepartmentsTableSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            ['NameDept' => 'Ban lãnh đạo', 'Group' => ''],
            ['NameDept' => 'Phòng Kế hoạch', 'Group' => ''],
            ['NameDept' => 'Phòng Kế toán', 'Group' => ''],
            ['NameDept' => 'Phòng Phân tích cấu hình', 'Group' => ''],
            ['NameDept' => 'Phòng Thiết kế Đồ gá', 'Group' => ''],
            ['NameDept' => 'Phòng Quản lý dự án KD', 'Group' => ''],
            ['NameDept' => 'Phòng Quản trị dữ liệu', 'Group' => ''],
            ['NameDept' => 'Phòng Sản phẩm xe Du lịch', 'Group' => 'SP'],
            ['NameDept' => 'Phòng Sản phẩm xe Tải, Bus & SMRM', 'Group' => 'SP'],
            ['NameDept' => 'Phòng Thiết kế hệ thống thủy khí', 'Group' => ''],
            ['NameDept' => 'Phòng Thiết kế khung gầm', 'Group' => 'TK'],
            ['NameDept' => 'Phòng Thiết kế Kiểu dáng', 'Group' => 'TK'],
            ['NameDept' => 'Phòng Thiết kế xe Bus', 'Group' => 'TK'],
            ['NameDept' => 'Phòng Thiết kế xe Tải', 'Group' => 'TK'],
            ['NameDept' => 'Phòng Thiết kế xe Royal & Năng lượng mới', 'Group' => 'TK'],
            ['NameDept' => 'Phòng Thiết kế hệ thống điện & Điều hòa', 'Group' => 'TK'],
            ['NameDept' => 'Phòng Thiết kế nội ngoại thất', 'Group' => 'TK'],
            ['NameDept' => 'Phòng Động lực học', 'Group' => 'TK'],
            ['NameDept' => 'Phòng Thử nghiệm', 'Group' => 'MP-TN'],
            ['NameDept' => 'Phòng Mô phỏng', 'Group' => 'MP-TN'],
            ['NameDept' => 'Kho vật tư', 'Group' => 'XM'],
            ['NameDept' => 'Xưởng Sản xuất mẫu xe Bus', 'Group' => 'XM'],
            ['NameDept' => 'Xưởng Sản xuất mẫu xe Tải', 'Group' => 'XM'],
            ['NameDept' => 'Xưởng Sản xuất mẫu xe Royal & Du lịch', 'Group' => 'XM'],
            ['NameDept' => 'Phòng Quản lý chất lượng', 'Group' => 'XM'],
        ]);
    }
}
