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
     * Model name.
     */
    protected const _model_name = "User";

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
            ActivityLog::create([ "description" => "Create user ".$user->name."." ]);
        });
    }

    /**
     * Function to handle serve record.
     */
    public static function serveRecord(){
        $global = Globalization::index();
        $menu_id = Menu::where("name", self::_model_name)->get()->last()->id ?? NULL;
        $description = Documentation::where("menu_id", $menu_id)->get();
        $user = self::all();
        return view("user.index", compact("global", "description", "user"));
    }

    /**
     * Function to handle show creation form.
     */
    public static function showCreationForm(){
        $global = Globalization::index();
        return view("user.create", compact("global"));
    }

    /**
     * Function to handle record storing.
     */
    public static function handleStore($request){
        $request->request->add(['password' => self::hashPassword($request)]);
        self::create($request->all());
        return redirect()->route("user.index")->with("success", ucfirst("user has been stored."));
    }

    /**
     * Function to handle show specific record.
     */
    public static function showSpecificRecord($id){
        $global = Globalization::index();
        $user = self::whereId($id)->get()->last();
        return view("user.show", compact("global", "user"));
    }

    /**
     * Function to handle show editing form.
     */
    public static function showEditingForm($id){
        $global = Globalization::index();
        $user = self::whereId($id)->get()->last();
        return view("user.edit", compact("global", "user"));
    }

    /**
     * Function to handle record modification.
     */
    public static function handleUpdate($request, $id){
        self::whereId($id)->update([
            "role_id" => $request->role_id,
            "name" => $request->name,
            "username" => $request->username,
        ]);
        $change = ActivityLog::checkModification(self::_model_name, $request, $id);
        ActivityLog::writeLog(Auth()->user()->name." update user ".$request->old_name.$change.".");
        return redirect()->route("user.index")->with("success", ucfirst("user has been updated."));
    }

    /**
     * Function to handle record deletion.
     */
    public static function handleDelete($id){
        $change = ActivityLog::checkDeletion(self::_model_name, $id);
        ActivityLog::writeLog(Auth()->user()->name." delete user ".$change.".");
        self::whereId($id)->delete();
        return redirect()->route("user.index")->with("success", ucfirst("user has been deleted."));
    }
}
