<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;


// Routes for authentication
Route::get('/', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('/', [AuthController::class, 'login'])->name('auth.login.submit');
Route::get('/auth/register', [AuthController::class, 'showRegistrationForm'])->name('auth.register');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register.submit');
Route::get('/auth/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('auth.forgot-password');
Route::post('/auth/forgot-password', [AuthController::class, 'sendResetLink'])->name('auth.forgot-password.submit');
Route::get('/auth/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('auth.reset-password');
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password.submit');
Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::get('/dashboard', [PropertyController::class, 'index'])->name('dashboard');


Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
Route::get('/properties/{property}/show', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/properties/{property}', [PropertyController::class, 'edit'])->name('properties.edit');
Route::put('/properties/{property}/update', [PropertyController::class, 'update'])->name('properties.update.submit');
Route::delete('/properties/{property}/delete', [PropertyController::class, 'destroy'])->name('properties.destroy');


