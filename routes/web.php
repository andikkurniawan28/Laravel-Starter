<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserActivationController;


Route::get("/", DashboardController::class)->name("dashboard")->middleware(["auth"]);

Route::get("login", [AuthController::class, "login"])->name("login");
Route::get("logout", [AuthController::class, "logout"])->name("logout");
Route::get("register", [AuthController::class, "register"])->name("register");
Route::post("login", [AuthController::class, "loginProcess"])->name("login.process");
Route::post("register", [AuthController::class, "registerProcess"])->name("register.process");

Route::resource("menu", MenuController::class)->middleware(["auth", "ensure.permission"]);
Route::resource("role", RoleController::class)->middleware(["auth", "ensure.permission"]);
Route::resource("permission", PermissionController::class)->middleware(["auth", "ensure.permission"]);
Route::resource("user", UserController::class)->middleware(["auth", "ensure.permission"]);

Route::get("setting", [SettingController::class, "index"])->name("setting.index")->middleware(["auth", "ensure.permission"]);
Route::post("setting", [SettingController::class, "process"])->name("setting.process")->middleware(["auth", "ensure.permission"]);
Route::get("user/activation/{user_id}", UserActivationController::class)->name("user.activation")->middleware(["auth", "ensure.permission"]);
Route::get("activity_log", [ActivityLogController::class, "index"])->name("activity_log")->middleware(["auth", "ensure.permission"]);
