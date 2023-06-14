<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Globalization;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRegisterRequest;

class AuthController extends Controller
{
    public function login(){
        $global = Globalization::index();
        return view("auth.login", compact("global"));
    }

    public function register(){
        $global = Globalization::index();
        return view("auth.register", compact("global"));
    }

    public function changePassword(){
        $global = Globalization::index();
        return view("auth.change_password", compact("global"));
    }

    public function loginProcess(Request $request){
        return User::handleLogin($request);
    }

    public function registerProcess(Request $request){
        return User::handleRegister($request);
    }

    public function logout(Request $request){
        return User::handleLogout($request);
    }

    public function changePasswordProcess(Request $request){
        return User::handleChangePassword($request);
    }
}
