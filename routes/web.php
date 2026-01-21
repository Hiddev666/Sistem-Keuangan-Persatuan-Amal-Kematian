<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth
Route::get("sign-in", [AuthController::class, 'signIn'])->name("sign-in");
Route::post("login", [AuthController::class, 'login'])->name("login");
Route::post("logout", [AuthController::class, 'logout'])->middleware('auth')->name("logout");
Route::get("registration/pay/{id}", [PaymentController::class, 'payRegistration'])->name("registration_pay");


// Admin
Route::middleware(['auth:web'])->group(function () {
    Route::get("admin/dashboard", [AdminController::class, 'index'])->name("admin_dashboard");

    // Keanggotaan
    Route::get("admin/keanggotaan", [AdminController::class, 'keanggotaan'])->name("admin_keanggotaan");
    Route::get("admin/keanggotaan/add", [AdminController::class, 'addKeanggotaan'])->name("admin_keanggotaan_add");
    Route::post("admin/keanggotaan/create", [AdminController::class, 'createKeanggotaan'])->name("admin_keanggotaan_create");
    Route::get("admin/keanggotaan/edit/{id}", [AdminController::class, 'editKeanggotaan'])->name("admin_keanggotaan_edit");
    Route::post("admin/keanggotaan/update", [AdminController::class, 'updateKeanggotaan'])->name("admin_keanggotaan_update");
    Route::post("admin/keanggotaan/anggota/update", [AdminController::class, 'updateKeanggotaanAnggota'])->name("admin_keanggotaan_anggota_update");
    Route::get("admin/keanggotaan/delete/{id}", [AdminController::class, 'deleteKeanggotaan'])->name("admin_keanggotaan_delete");
    Route::get("admin/keanggotaan/search", [AdminController::class, 'searchKeanggotaan'])->name("admin_keanggotaan_search");

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

    // Kejadian Duka
    Route::get("admin/duka", [AdminController::class, 'duka'])->name("admin_duka");
    Route::get("admin/duka/detail/{id}", [AdminController::class, 'detailDuka'])->name("admin_duka_detail");
    Route::get("admin/duka/detail/confirm/form/{id}", [AdminController::class, 'confirmDukaForm'])->name("admin_duka_confirm_form");
    Route::post("admin/duka/detail/confirm", [AdminController::class, 'confirmDuka'])->name("admin_duka_confirm");
    Route::get("admin/duka/detail/contrib/edit/{id}", [AdminController::class, 'editDukaContrib'])->name("admin_duka_contrib_edit");
    Route::get("admin/duka/detail/contrib/delete/{id}", [AdminController::class, 'deleteDukaContrib'])->name("admin_duka_contrib_delete");
    Route::post("admin/duka/detail/contrib/update", [AdminController::class, 'updateDukaContrib'])->name("admin_duka_contrib_update");
    Route::get("admin/duka/search", [AdminController::class, 'searchDuka'])->name("admin_duka_search");
    Route::get("admin/duka/add", [AdminController::class, 'addDuka'])->name("admin_duka_add");
    Route::post("admin/duka/create", [AdminController::class, 'createDuka'])->name("admin_duka_create");
    Route::get("admin/duka/edit/{id}", [AdminController::class, 'editDuka'])->name("admin_duka_edit");
    Route::post("admin/duka/update", [AdminController::class, 'updateDuka'])->name("admin_duka_update");
    Route::get("admin/duka/delete/{id}", [AdminController::class, 'deleteDuka'])->name("admin_duka_delete");

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
    Route::get("member/payments", [MemberController::class, 'kas'])->name("member_kas");
    Route::get("member/kas/pay/{id}", [PaymentController::class, 'payContribution'])->name("member_kas_pay");
    Route::get("member/kas/pay", [PaymentController::class, 'payContributions'])->name("member_kas_pays");
    Route::get("member/donasi", [MemberController::class, 'donasi'])->name("member_donasi");
    Route::post("member/donasi/pay", [PaymentController::class, 'payDonation'])->name("member_donasi_pay");
    Route::get("member/histories", [MemberController::class, 'riwayat'])->name("member_riwayat");
});
