<?php

use App\Http\Controllers\TopicController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('setlocale/{locale}/', function ($locale) {
    session(['locale' => $locale]);
    return back();
})->name('setlocale');

Route::group(['middleware' => 'setlocale'], function () {
    Route::get('/', [TopicController::class, 'index'])->name('index');

    Route::resource('topics', TopicController::class);

    Route::get('/topics/{id}/restore', [TopicController::class, 'restore'])->name('topics.restore');

    Route::resource('posts', PostController::class);

    Route::get('/posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');

    Route::resource('posts.comments', CommentController::class)->shallow()->only('store', 'edit', 'update', 'destroy');

    Route::get('/comments/{id}/restore', [CommentController::class, 'restore'])->name('comments.restore');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile/edit', 'edit')->name('profile.edit');
        Route::delete('profile', 'destroy')->middleware('password.confirm')->name('profile.destroy');
        Route::get('/profile/{part?}', 'show')->where('part', '[a-z]+')->name('profile.show');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index');
        Route::get('/users/{user}/{part?}', 'show')->where('part', '[a-z]+')->name('users.show');
    });
});
