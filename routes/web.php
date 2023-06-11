<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserActivationController;


Route::get("/", DashboardController::class)->name("dashboard")->middleware(["auth"]);

Route::get("login", [AuthController::class, "login"])->name("login");
Route::get("logout", [AuthController::class, "logout"])->name("logout");
Route::get("register", [AuthController::class, "register"])->name("register");
Route::post("login", [AuthController::class, "login_process"])->name("login_process");
Route::post("register", [AuthController::class, "register_process"])->name("register_process");

Route::resource("user", UserController::class)->middleware(["auth"]);
Route::resource("role", RoleController::class)->middleware(["auth"]);
Route::resource("menu", MenuController::class)->middleware(["auth"]);
Route::resource("permission", PermissionController::class)->middleware(["auth"]);

Route::get("setting", [SettingController::class, "index"])->name("setting")->middleware(["auth"]);
Route::post("setting", [SettingController::class, "process"])->name("setting_process")->middleware(["auth"]);
Route::get("user_activation/{user_id}", UserActivationController::class)->name("user_activation")->middleware(["auth"]);
