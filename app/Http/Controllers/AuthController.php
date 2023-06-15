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
    /**
     * Display a form to login.
     */
    public function login(){
        $global = Globalization::index();
        return view("auth.login", compact("global"));
    }

    /**
     * Display a form to register.
     */
    public function register(){
        $global = Globalization::index();
        return view("auth.register", compact("global"));
    }

    /**
     * Display a form to change password.
     */
    public function changePassword(){
        $global = Globalization::index();
        return view("auth.change_password", compact("global"));
    }

    /**
     * Function to handle login process.
     */
    public function loginProcess(Request $request){
        return User::handleLogin($request);
    }

    /**
     * Function to handle register process.
     */
    public function registerProcess(Request $request){
        return User::handleRegister($request);
    }

    /**
     * Function to handle logout process.
     */
    public function logout(Request $request){
        return User::handleLogout($request);
    }

    /**
     * Function to handle change [password process.
     */
    public function changePasswordProcess(Request $request){
        return User::handleChangePassword($request);
    }
}
