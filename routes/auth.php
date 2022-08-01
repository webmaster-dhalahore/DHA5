<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserManagement\LoginController as UserManagementLoginController;
use App\Http\Controllers\UserManagement\UserAccountsController;
use App\Http\Controllers\UserManagement\UserComputerController;
use App\Http\Controllers\UserManagement\UserRolesController;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout',  [LoginController::class, 'logout'])->name('logout');
Route::get('logout',  [LoginController::class, 'logout'])->name('logout');
// Route::get('login', [UserManagementLoginController::class, 'showLoginForm'])->name('login');
// Route::post('login', [UserManagementLoginController::class, 'login']);
// Route::post('logout',  [UserAccountsController::class, 'logout'])->name('logout');
// Route::get('logout',  [UserAccountsController::class, 'logout'])->name('logout');

Route::post('change-pwd',  [ResetPasswordController::class, 'changePwd'])->name('changePassword');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// User Accounts Routes
