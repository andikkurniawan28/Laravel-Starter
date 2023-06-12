<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
