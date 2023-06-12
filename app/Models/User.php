<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\ActivityLog;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    public static function hashPassword($request){
        return bcrypt($request->password);
    }

    public static function checkUserIsPresent($request){
        return self::where("username", $request->username)->count();
    }

    public static function checkUserIsActivated($request){
        $status = self::where("username", $request->username)->get()->last()->is_activated;
        if($status === 0){
            return false;
        } else {
            return true;
        }
    }

    public static function handleLogin($request){
        $user_is_present = self::checkUserIsPresent($request);
        if($user_is_present > 0){
            $user_is_active = self::checkUserIsActivated($request);
            if($user_is_active){
                return self::processLogin($request);
            }
            else {
                return redirect()->back()->with("success", "User is not activated !");
            }
        }
        else {
            return redirect()->back()->with("success", "User is not found !");
        }
    }

    public static function processLogin($request){
        $attempt = Auth::attempt([
            "username" => $request->username,
            "password" => $request->password,
            "is_activated" => 1,
        ]);
        if($attempt){
            $request->session()->regenerate();
            return redirect()->intended();
        }
        else{
            return redirect("login")->with("success", "Password is wrong !");
        }
    }

    public static function handleRegister($request){
        $request->request->add([
            "password" => User::hashPassword($request),
        ]);
        User::create($request->all());
        return redirect()->route("login");
    }

    public static function handleLogout($request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("login");
    }

    public function role(){
        return $this->belongsTo(Role::class);
    }

    protected static function booted(): void
    {
        parent::boot();
        static::created(function (User $user) {
            ActivityLog::create([ "description" => "Create user ".$user->name ]);
        });
    }
}
