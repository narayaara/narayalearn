<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

// Public
Route::get('/subjects', [\App\Http\Controllers\SubjectContentController::class, 'index'])->name('subjects.index');
Route::get('/subjects/{subject}', [\App\Http\Controllers\SubjectContentController::class, 'show'])->name('subjects.show');
Route::get('/subjects/{subject}/topics/{topic}', [\App\Http\Controllers\SubjectContentController::class, 'showTopic'])->name('subjects.topic');
Route::get('/materials/{material}', [\App\Http\Controllers\SubjectContentController::class, 'showMaterial'])->name('materials.show');
Route::get('/materials/{material}/download', [\App\Http\Controllers\SubjectContentController::class, 'download'])->name('materials.download');

// User (login)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/favorites', [\App\Http\Controllers\ProfileController::class, 'favorites'])->name('profile.favorites');
    Route::get('/account', [\App\Http\Controllers\ProfileController::class, 'index'])->name('account.index');

    Route::post('/materials/{material}/favorite', [\App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

// Admin (login + role admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/subjects', \App\Http\Controllers\Admin\SubjectController::class);
    Route::resource('/materials', \App\Http\Controllers\Admin\MaterialController::class)->except('show');

    Route::get('/avatars', [\App\Http\Controllers\Admin\AvatarController::class, 'index'])->name('avatars.index');
    Route::post('/avatars', [\App\Http\Controllers\Admin\AvatarController::class, 'store'])->name('avatars.store');
    Route::delete('/avatars/{avatar}', [\App\Http\Controllers\Admin\AvatarController::class, 'destroy'])->name('avatars.destroy');

    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');
});