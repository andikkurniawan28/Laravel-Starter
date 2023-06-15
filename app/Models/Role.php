<?php

namespace App\Models;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->hasMany(User::class);
    }

    public function permission(){
        return $this->hasMany(Permission::class);
    }

    protected static function booted(): void
    {
        parent::boot();
        static::created(function (Role $role) {
            ActivityLog::create([ "description" => Auth()->user()->name." create role ".$role->name ]);
        });
    }

    public static function updateLog($request){
        ActivityLog::create([
            "description" => Auth()->user()->name." update role ".$request->name
        ]);
    }

    public static function deleteLog($request){
        ActivityLog::create([
            "description" => Auth()->user()->name." delete role ".$request->name
        ]);
    }
}
