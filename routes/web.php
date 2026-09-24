<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

// ====================
// HOME (Public)
// ====================
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// ====================
// PUBLIC (Bisa diakses tanpa login)
// ====================
Route::get('/subjects', [App\Http\Controllers\SubjectContentController::class, 'index'])->name('subjects.index');
Route::get('/subjects/{subject}', [App\Http\Controllers\SubjectContentController::class, 'show'])->name('subjects.show');
Route::get('/subjects/{subject}/topics/{topic}', [App\Http\Controllers\SubjectContentController::class, 'showTopic'])->name('subjects.topic');
Route::get('/materials/{material}', [App\Http\Controllers\SubjectContentController::class, 'showMaterial'])->name('materials.show');
Route::get('/materials/{material}/download', [App\Http\Controllers\SubjectContentController::class, 'download'])->name('materials.download');

// ====================
// AUTHENTICATED USER (Login Required)
// ====================
Route::middleware(['auth'])->group(function () {
    // Profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/favorites', [App\Http\Controllers\ProfileController::class, 'favorites'])->name('profile.favorites');
    Route::get('/account', [App\Http\Controllers\ProfileController::class, 'index'])->name('account.index');

    // Comments
    Route::post('/materials/{material}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');

    // Favorites
    Route::post('/materials/{material}/favorite', [App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');
});

// ====================
// ADMIN (Login + Role Admin)
// ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Subjects
    Route::resource('/subjects', App\Http\Controllers\Admin\SubjectController::class)->names('subjects');

    // Materials
    Route::resource('/materials', App\Http\Controllers\Admin\MaterialController::class)->names('materials');

    // Users
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.destroy');

    // Comments
    Route::get('/comments', [App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comments.index');
    Route::delete('/comments/{comment}', [App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('comments.destroy');
});