<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth
Route::get("sign-in", [AuthController::class, 'signIn'])->name("sign-in");
Route::post("login", [AuthController::class, 'login'])->name("login");
Route::post("logout", [AuthController::class, 'logout'])->middleware('auth')->name("logout");

// Admin
Route::middleware('auth')->get("admin/dashboard", [AdminController::class, 'index'])->name("admin_dashboard");
Route::middleware('auth')->get("admin/anggota", [AdminController::class, 'anggota'])->name("admin_anggota");
Route::middleware('auth')->get("admin/anggota/add", [AdminController::class, 'addAnggota'])->name("admin_anggota_add");
Route::middleware('auth')->post("admin/anggota/create", [AdminController::class, 'createAnggota'])->name("admin_anggota_create");
