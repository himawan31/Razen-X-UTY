<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PropertyController;


// Routes for authentication 
Route::get('/', [AuthController::class, 'showUserLoginForm'])->name('login');
Route::post('/', [AuthController::class, 'loginUser'])->name('auth.user.login.submit');

Route::get('/login/admin', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/login/admin', [AuthController::class, 'loginAdmin'])->name('auth.admin.login.submit');

Route::get('/auth/register', [AuthController::class, 'showRegistrationForm'])->name('auth.register');
Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register.submit');

Route::get('/auth/forgot-password', [AuthController::class, 'ForgotPassword'])->name('auth.forgot-password');
Route::post('/auth/forgot-password', [AuthController::class, 'ForgotPasswordForm'])->name('auth.forgot-password.submit');

Route::get('/auth/reset-password/{token}', [AuthController::class, 'ResetPassword'])->name('password.reset');
Route::post('/auth/reset-password', [AuthController::class, 'resetPasswordForm'])->name('auth.reset-password.submit');

Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');


Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [PropertyController::class, 'indexDashboard'])->name('dashboard');
    Route::get('/home', [PropertyController::class, 'indexHome'])->name('home');
    Route::get('/details/{property}/', [PropertyController::class, 'detailProperty'])->name('details');
    // Route for favorites
    Route::get('/favorites', [PropertyController::class, 'indexFavorites'])->name('favorites');
    Route::post('/favorites/{property}', [PropertyController::class, 'addToFavorites'])->name('favorites.add');
    Route::delete('/favorites/{property}', [PropertyController::class, 'removeFromFavorites'])->name('favorites.remove');
    // Route for properties
    Route::get('/properties/{property}/show', [PropertyController::class, 'show'])->name('properties.show');
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/show', [PropertyController::class, 'show'])->name('properties.show');
    Route::get('/properties/{property}', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}/update', [PropertyController::class, 'update'])->name('properties.update.submit');
    Route::delete('/properties/{property}/delete', [PropertyController::class, 'destroy'])->name('properties.destroy');
});


