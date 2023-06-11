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

    public function login_process(Request $request){
        $attempt = Auth::attempt([
            "username" => $request->username,
            "password" => $request->password,
        ]);
        if($attempt){
            $request->session()->regenerate();
            return redirect()->intended();
        }
        else{
            return redirect("login")->with("error", "Username / password wrong.");
        }
    }

    public function register_process(Request $request){
        $request->request->add([
            'password' => User::hashPassword($request),
        ]);
        User::create($request->all());
        return redirect()->route('login');

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("login");
    }
}
