<?php

use Illuminate\Support\Facades\Route;

Auth::routes();


// ====================
// HOME
// ====================

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home');


// ADMIN

Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');

Route::resource('/admin/subjects', App\Http\Controllers\Admin\SubjectController::class)
    ->middleware(['auth', 'admin'])
    ->names('admin.subjects');

Route::resource('/admin/materials', App\Http\Controllers\Admin\MaterialController::class)
    ->middleware(['auth', 'admin'])
    ->names('admin.materials');

Route::get('/admin/users', [App\Http\Controllers\Admin\UserController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.users.index');

Route::delete('/admin/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])
    ->middleware(['auth', 'admin'])
    ->name('admin.users.destroy');

Route::get('/admin/comments', [App\Http\Controllers\Admin\CommentController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.comments.index');

Route::delete('/admin/comments/{comment}', [App\Http\Controllers\Admin\CommentController::class, 'destroy'])
    ->middleware(['auth', 'admin'])
    ->name('admin.comments.destroy');


// ====================
// PUBLIC
// ====================

Route::get('/subjects', [App\Http\Controllers\SubjectContentController::class, 'index'])
    ->name('subjects.index');

Route::get('/subjects/{subject}', [App\Http\Controllers\SubjectContentController::class, 'show'])
    ->name('subjects.show');

Route::get('/materials/{material}', [App\Http\Controllers\SubjectContentController::class, 'showMaterial'])
    ->name('materials.show');

Route::get('/materials/{material}/download', [App\Http\Controllers\SubjectContentController::class, 'download'])
    ->name('materials.download');


// ====================
// PROFILE
// ====================

Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])
    ->name('profile.index');

Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])
    ->name('profile.update');

Route::get('/account', [App\Http\Controllers\ProfileController::class, 'index'])
    ->name('account.index');


// ====================
// AUTHENTICATED USER
// ====================

Route::post('/materials/{material}/comments', [App\Http\Controllers\CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');

Route::delete('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])
    ->middleware('auth')
    ->name('comments.destroy');

Route::post('/materials/{material}/favorite', [App\Http\Controllers\FavoriteController::class, 'toggle'])
    ->middleware('auth')
    ->name('favorites.toggle');

// ===== PROFILE ROUTES =====
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/favorites', [App\Http\Controllers\ProfileController::class, 'favorites'])->name('profile.favorites');
});