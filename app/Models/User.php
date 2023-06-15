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

    /**
     * All fields are accessible.
     */
    protected $guarded = [];

    /**
     * Function to hash / encrypt password from user request.
     */
    public static function hashPassword($request){
        return bcrypt($request->password);
    }

    /**
     * Function to count how many user with user request.
     */
    public static function checkUserIsPresent($request){
        return self::where("username", $request->username)->count();
    }

    /**
     * Function to check if user request is activated or not.
     */
    public static function checkUserIsActivated($request){
        $status = self::where("username", $request->username)->get()->last()->is_activated;
        if($status === 0){
            return false;
        } else {
            return true;
        }
    }

    /**
     * Function to handle login validation.
     */
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

    /**
     * Function to handle login process.
     */
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

    /**
     * Function to handle register process.
     */
    public static function handleRegister($request){
        $request->validate([
            "name" => "required|unique:users",
            "username" => "required|unique:users",
        ]);
        $request->request->add([
            "password" => User::hashPassword($request),
        ]);
        self::create($request->all());
        return redirect("login")->with("success", "User registered successfully !");
    }

    /**
     * Function to handle logout process.
     */
    public static function handleLogout($request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("login");
    }

    /**
     * Function to handle change password process.
     */
    public static function handleChangePassword($request){
        self::whereId($request->user_id)->update([
            "password" => bcrypt($request->password)
        ]);
        return redirect()->route("logout");
    }

    /**
     * Declare relationship with Role Model.
     */
    public function role(){
        return $this->belongsTo(Role::class);
    }

    /**
     * Function to perform logging every time a new record is created.
     */
    protected static function booted(): void
    {
        parent::boot();
        static::created(function (User $user) {
            ActivityLog::create([ "description" => "Create user ".$user->name ]);
        });
    }

    /**
     * Function to perform logging every time a new record is updated.
     */
    public static function updateLog($request){
        ActivityLog::create([
            "description" => Auth()->user()->name." update user ".$request->name
        ]);
    }

    /**
     * Function to perform logging every time a new record is deleted.
     */
    public static function deleteLog($request){
        ActivityLog::create([
            "description" => Auth()->user()->name." delete user ".$request->name
        ]);
    }
}
