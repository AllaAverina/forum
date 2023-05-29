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
    Route::get('', [TopicController::class, 'index'])->name('index');

    Route::resource('topics', TopicController::class);
    Route::patch('topics/{id}/restore', [TopicController::class, 'restore'])->name('topics.restore');

    Route::resource('posts', PostController::class);
    Route::patch('posts/{id}/restore', [PostController::class, 'restore'])->name('posts.restore');

    Route::resource('posts.comments', CommentController::class)->shallow()->only('store', 'edit', 'update', 'destroy');
    Route::patch('comments/{id}/restore', [CommentController::class, 'restore'])->name('comments.restore');

    Route::group(['prefix' => 'profile', 'middleware' => 'auth', 'controller' => ProfileController::class], function () {
        Route::get('edit', 'edit')->name('profile.edit');
        Route::get('{part?}', 'show')->where('part', '[a-z]+')->name('profile.show');
        Route::delete('', 'destroy')->middleware('password.confirm')->name('profile.destroy');
    });

    Route::group(['prefix' => 'users', 'controller' => UserController::class], function () {
        Route::get('', 'index')->name('users.index');
        Route::get('{user}/{part?}', 'show')->where('part', '[a-z]+')->name('users.show');
    });
});
