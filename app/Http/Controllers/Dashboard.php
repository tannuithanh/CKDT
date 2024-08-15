<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Dashboard extends Controller
{
    public function dashboard(){
        $users = $this->getUsers();
        return view('dashBoard',compact('users'));
    }
}
