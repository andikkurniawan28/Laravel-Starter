<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function role(){
        return $this->belongsTo(Role::class);
    }

    public function menu(){
        return $this->belongsTo(Menu::class);
    }

    protected static function booted(): void
    {
        parent::boot();
        static::created(function (Permission $permission) {
            ActivityLog::create([ "description" => Auth()->user()->name." create permission for ".$permission->role->name." to access ".$permission->menu->name ]);
        });
    }

    public static function updateLog(){
        ActivityLog::create([
            "description" => Auth()->user()->name." update permission"
        ]);
    }

    public static function deleteLog(){
        ActivityLog::create([
            "description" => Auth()->user()->name." delete permission"
        ]);
    }
}
