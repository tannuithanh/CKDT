<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class Setting extends Controller
{
    public function profile(){
        $users = $this->getUsers();
        return view('setting.profile',compact('users'));
    }

    public function uploadAvatar(Request $request){
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        $fileName = $user->FullName . $user->MSNV . '.' . $request->file('avatar')->getClientOriginalExtension();
        $filePath = 'avatar/' . $fileName;

        // Lưu file vào thư mục avatar
        $request->file('avatar')->move(public_path('avatar'), $fileName);

        // Cập nhật đường dẫn avatar trong database
        $user->Avatar = $filePath;
        $user->save();

        return back()->with('success', 'Avatar updated successfully.');
    }

    public function settingSystem(){
        $users = $this->getUsers();
        if (!$users || $users->Admin != 1) {
            return back()->with('error', 'Bạn không có quyền truy cập vào trang này.');
        }
        $usersAll = $this->getUsersAll();
        $positions = $this->getPositions();
        $departments = $this->getDepartments();
        return view('setting.settingSystem',compact('users','usersAll','positions','departments'));
    }

    public function getUserById($id){
        $user = User::with(['position', 'department'])->findOrFail($id);
        $positions = Position::all();
        $departments = Department::all();

        return response()->json([
            'user' => $user,
            'positions' => $positions,
            'departments' => $departments
        ]);
    }

    public function editUserById(Request $request){
        $request->validate([
            'userId' => 'required|exists:users,id',
            'fullName' => 'required|string|max:255',
            'position' => 'required|exists:positions,id',
            'positionDetail' => 'nullable|string|max:255',
            'mail' => 'required|email|max:255',
            'department' => 'required|exists:departments,id',
            'admin' => 'required|boolean'
        ]);

        $user = User::findOrFail($request->userId);
        $user->FullName = $request->fullName;
        $user->IDPosition = $request->position;
        $user->PositionDetail = $request->positionDetail;
        $user->MailAddress = $request->mail;
        $user->IDDepartment = $request->department;
        $user->Division = $request->division;
        $user->Admin = $request->admin;
        $user->save();

        $user = User::with(['position', 'department'])->findOrFail($user->id);

        return response()->json([
            'success' => 'Cập nhật thông tin thành công',
            'user' => $user,
        ]);
    }

    public function filterUsers(Request $request) {
        $departmentId = $request->departmentId;
        $positionId = $request->positionId;

        $query = User::query();

        if ($departmentId) {
            $query->where('IDDepartment', $departmentId);
        }

        if ($positionId) {
            $query->where('IDPosition', $positionId);
        }

        $users = $query->get();
        return response()->json($users);
    }

    public function getDataUsers(Request $request) {
        $departmentId = $request->departmentId;
        $positionId = $request->positionId;
        $userId = $request->userId;

        $query = User::with(['department', 'position']);

        if ($userId) {
            $query->where('id', $userId);
        } else {
            if ($departmentId) {
                $query->where('IDDepartment', $departmentId);
            }

            if ($positionId) {
                $query->where('IDPosition', $positionId);
            }
        }
        $users = $query->paginate(20);
        return response()->json($users);
    }

    public function uploadSignature(Request $request){
        $request->validate([
            'signature' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        $fileName = $user->FullName . $user->MSNV . '_signature.' . $request->file('signature')->getClientOriginalExtension();
        $filePath = 'signatures/' . $fileName;

        // Lưu file vào thư mục signatures
        $request->file('signature')->move(public_path('signatures'), $fileName);


        // Cập nhật đường dẫn chữ ký số trong database
        $user->Signature = $filePath;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function deleteUserById(Request $request){
        // Validate dữ liệu đầu vào
        $request->validate([
            'id' => 'required|exists:users,id' // Đảm bảo rằng ID người dùng tồn tại trong bảng users
        ]);

        // Tìm và xóa người dùng
        $user = User::find($request->id);
        $user->delete();

        // Trả về phản hồi JSON thành công
        return response()->json(['success' => true, 'message' => 'Người dùng đã được xóa thành công']);
    }


    public function editDivision(Request $request){
        // Validate dữ liệu
        $request->validate([
            'division' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id'
        ]);

        // Tìm user bằng user_id và cập nhật Division
        $user = User::find($request->user_id);
        $user->Division = $request->division;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Bộ phận đã được cập nhật']);
    }

}
