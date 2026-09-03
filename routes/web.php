<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\MaterialController; 
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\SubjectContentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function ()  {
    Route::resource('subjects', SubjectController::class);
    Route::resource('materials', MaterialController::class);
    Route::resource('users', UserController::class)->only(['index', 'destroy']);
});

Route::get('/subjects', [SubjectContentController::class, 'index'])->name('subjects.index');
Route::get('/subjects/{subject}', [SubjectContentController::class, 'show'])->name('subjects.show');
Route::get('/materials/{material}', [SubjectContentController::class, 'showMaterial'])->name('materials.show');
Route::get('/materials/{material}/download', [SubjectContentController::class, 'download'])->name('materials.download');

Route::middleware(['auth'])->group(function () {
    Route::post('/materials/{material}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/materials/{material}/favorite', [FavoriteController::class, 'toggle'])->name('favorites.toggle');
});