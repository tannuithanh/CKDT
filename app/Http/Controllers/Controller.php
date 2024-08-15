<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    //Lấy người dùng đăng nhập
    public function getUsers(){
        $user = User::with(['position', 'department'])->find(Auth::id());
        return $user;
    }

    //Lấy tất cả người dùng
    public function getUsersAll() {
        $users = User::with(['position', 'department'])->paginate(20);
        return $users;
    }

    //Lấy phòng ban
    public function getDepartments(){
        $departments = Department::all();
        return $departments;
    }

    //Lấy chức vụ
    public function getPositions(){
        $positions = Position::all();
        return $positions;
    }

    //Lấy danh sách xem xét giấy xin phép
    public function getUserConsider() {
        $user = User::with(['position', 'department'])->find(Auth::id());
        $position = $user->IDPosition;
        $department = $user->IDDepartment;
        $group = $user->department->group;
        if ($position >= 8 && $position <= 15) {
            return User::where('IDDepartment', $department)
                        ->whereIn('IDPosition', [6, 7])
                        ->get();
        }

        if ($position == 7) {
            if ($group == 'TK') {
                return User::where('IDPosition', 6)
                            ->where('IDDepartment', $department)
                            ->orWhere('IDPosition', 4)
                            ->get();
            } elseif ($group == 'MP-TN') {
                return User::where('IDPosition', 6)
                            ->where('IDDepartment', $department)
                            ->orWhere('IDPosition', 5)
                            ->get();
            } elseif ($group == 'XM') {
                return User::where('IDPosition', 6)
                            ->where('IDDepartment', $department)
                            ->orWhere('IDPosition', 3)
                            ->get();
            }
        }

        if ($position == 6) {
            if ($group == 'TK') {
                return User::where('IDPosition', 4)->get();
            } elseif ($group == 'MP-TN') {
                return User::where('IDPosition', 5)->get();
            } elseif ($group == 'XM') {
                return User::where('IDPosition', 3)->get();
            }else{
                return User::where('IDPosition', 2)->get();
            }
        }

        if (in_array($position, [5, 4, 3])) {
            return User::where('IDPosition', 2)->get();
        }

        return collect(); // Trả về một collection rỗng nếu không có điều kiện nào phù hợp
    }

    //Lấy danh sách xem xét PYC CÔNG VIỆC
    public function getUserConsiderJobForm() {
        $user = User::with(['position', 'department'])->find(Auth::id());
        $position = $user->IDPosition;
        $department = $user->IDDepartment;

        if ($position == 6) {
            // Nếu position là 6, chỉ lấy những user có position là 6
            return User::where('IDDepartment', $department)
                        ->where('IDPosition', 6)
                        ->get();
        }

        if ($position == 7) {
            // Nếu position là 7, lấy những user có position là 6 trước
            $users = User::where('IDDepartment', $department)
                          ->where('IDPosition', 6)
                          ->get();

            // Nếu không có ai có position = 6, thì lấy những user có position = 7
            if ($users->isEmpty()) {
                $users = User::where('IDDepartment', $department)
                             ->where('IDPosition', 7)
                             ->get();
            }

            return $users;
        }

        if ($position >= 8 && $position <= 15) {
            // Nếu position từ 8 đến 15, lấy những user có position là 6 hoặc 7
            return User::where('IDDepartment', $department)
                        ->whereIn('IDPosition', [6, 7])
                        ->get();
        }

        if (in_array($position, [5, 4, 3])) {
            // Nếu position là 5, 4, hoặc 3, lấy những user có position là 2
            return User::where('IDPosition', 2)->get();
        }

        return collect(); // Trả về một collection rỗng nếu không có điều kiện nào phù hợp
    }



    //Lấy danh sách người dùng bàn giao
    public function getUserReplace() {
        // Lấy người dùng hiện tại và phòng ban của họ
        $user = User::with('department')->find(Auth::id());
        $department = $user->IDDepartment;
        $position = $user->IDPosition;
        $currentUserId = $user->id; // ID của người dùng hiện tại

        // Nếu người dùng có vị trí 5, 4, hoặc 3
        if (in_array($position, [5, 4, 3])) {
            // Lấy tất cả người dùng có vị trí 2, ngoại trừ người dùng hiện tại
            return User::where('IDPosition', 2)
                        ->where('id', '!=', $currentUserId)
                        ->get();
        }

        // Nếu không phải vị trí 5, 4, hoặc 3, lấy tất cả người dùng thuộc cùng phòng ban, ngoại trừ người dùng hiện tại
        return User::where('IDDepartment', $department)
                    ->where('id', '!=', $currentUserId)
                    ->get();
    }

}
