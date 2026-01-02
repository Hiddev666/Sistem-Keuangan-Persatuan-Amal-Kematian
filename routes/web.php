<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth
Route::get("sign-in", [AuthController::class, 'signIn'])->name("sign-in");
Route::post("login", [AuthController::class, 'login'])->name("login");
Route::post("logout", [AuthController::class, 'logout'])->middleware('auth')->name("logout");

// Admin
Route::middleware(['auth:web'])->group(function () {
    Route::get("admin/dashboard", [AdminController::class, 'index'])->name("admin_dashboard");

    // Keanggotaan
    Route::get("admin/keanggotaan", [AdminController::class, 'keanggotaan'])->name("admin_keanggotaan");
    Route::get("admin/keanggotaan/add", [AdminController::class, 'addKeanggotaan'])->name("admin_keanggotaan_add");
    Route::post("admin/keanggotaan/create", [AdminController::class, 'createKeanggotaan'])->name("admin_keanggotaan_create");
    Route::get("admin/keanggotaan/edit/{id}", [AdminController::class, 'editKeanggotaan'])->name("admin_keanggotaan_edit");
    Route::post("admin/keanggotaan/update", [AdminController::class, 'updateKeanggotaan'])->name("admin_keanggotaan_update");
    Route::get("admin/anggota/search", [AdminController::class, 'search'])->name("admin_anggota_search");
    Route::get("admin/anggota/delete/{id}", [AdminController::class, 'deleteAnggota'])->name("admin_anggota_delete");

    // Anggota
    Route::get("admin/anggota", [AdminController::class, 'anggota'])->name("admin_anggota");
    Route::get("admin/anggota/search", [AdminController::class, 'search'])->name("admin_anggota_search");
    Route::get("admin/anggota/add", [AdminController::class, 'addAnggota'])->name("admin_anggota_add");
    Route::post("admin/anggota/create", [AdminController::class, 'createAnggota'])->name("admin_anggota_create");
    Route::get("admin/anggota/edit/{id}", [AdminController::class, 'editAnggota'])->name("admin_anggota_edit");
    Route::post("admin/anggota/update", [AdminController::class, 'updateAnggota'])->name("admin_anggota_update");
    Route::get("admin/anggota/delete/{id}", [AdminController::class, 'deleteAnggota'])->name("admin_anggota_delete");

    // Kas Bulanan
    Route::get("admin/kas", [AdminController::class, 'kas'])->name("admin_kas");
    Route::get("admin/kas/search", [AdminController::class, 'searchKas'])->name("admin_kas_search");
    Route::get("admin/kas/add", [AdminController::class, 'addKas'])->name("admin_kas_add");
    Route::post("admin/kas/create", [AdminController::class, 'createKas'])->name("admin_kas_create");
    Route::get("admin/kas/edit/{id}", [AdminController::class, 'editKas'])->name("admin_kas_edit");
    Route::post("admin/kas/update", [AdminController::class, 'updateKas'])->name("admin_kas_update");
    Route::get("admin/kas/delete/{id}", [AdminController::class, 'deleteKas'])->name("admin_kas_delete");

    // Sumbangan
    Route::get("admin/sumbangan", [AdminController::class, 'sumbangan'])->name("admin_sumbangan");
    Route::get("admin/sumbangan/search", [AdminController::class, 'searchSumbangan'])->name("admin_sumbangan_search");
    Route::get("admin/sumbangan/add", [AdminController::class, 'addSumbangan'])->name("admin_sumbangan_add");
    Route::post("admin/sumbangan/create", [AdminController::class, 'createSumbangan'])->name("admin_sumbangan_create");
    Route::get("admin/sumbangan/edit/{id}", [AdminController::class, 'editSumbangan'])->name("admin_sumbangan_edit");
    Route::post("admin/sumbangan/update", [AdminController::class, 'updateSumbangan'])->name("admin_sumbangan_update");
    Route::get("admin/sumbangan/delete/{id}", [AdminController::class, 'deleteSumbangan'])->name("admin_sumbangan_delete");
});

Route::middleware(['auth:member'])->group(function () {
    Route::get("member/dashboard", [MemberController::class, 'index'])->name("member_dashboard");
});
