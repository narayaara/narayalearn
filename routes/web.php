<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\MaterialController; 
use App\Http\Controllers\Admin\UserController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('subjects', SubjectController::class);
    Route::resource('materials', MaterialController::class);
    Route::resource('users', UserController::class)->only(['index', 'destroy']);
});