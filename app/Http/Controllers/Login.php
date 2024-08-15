<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Login extends Controller
{
    public function login(){
        return view('login');
    }

    public function loginPost(Request $request){
        $users = $this->getUsers();
        $request->validate([
            'msnv' => 'required|string',
            'pass' => 'required|string',
        ]);
        $member = User::where('MSNV', $request->msnv)->first();
        if ($member && Hash::check($request->pass, $member->Pass)) {
            // Thông tin xác thực đúng, tiến hành đăng nhập người dùng
            Auth::login($member);

            // Chuyển hướng đến trang dashboard hoặc trang mà người dùng yêu cầu
            return redirect(route('dashboard'));
        } else {
            // Thông tin xác thực không đúng, trả về với thông báo lỗi
            return redirect()->back()->withErrors(['msnv' => 'Thông tin đăng nhập không đúng']);
        }
    }

    public function logOut(){
        Auth::logout();
        return redirect()->route('login.get');
    }
}
