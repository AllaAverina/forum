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

Route::get('setlocale/{locale}', function ($locale) {
    session(['locale' => $locale]);
    return back();
})->name('setlocale');

Route::group(['middleware' => 'setlocale'], function () {
    Route::get('', function () {
        return to_route('topics.index');
    });

    Route::resource('topics', TopicController::class);
    Route::group(['prefix' => 'topics', 'controller' => TopicController::class], function () {
        Route::patch('{topic}/restore', 'restore')->withTrashed()->name('topics.restore');
        Route::delete('{topic}/forceDestroy', 'forceDelete')->name('topics.forceDestroy');
    });

    Route::resource('posts', PostController::class);
    Route::group(['prefix' => 'posts', 'controller' => PostController::class], function () {
        Route::patch('{post}/restore', 'restore')->withTrashed()->name('posts.restore');
        Route::delete('{post}/forceDestroy', 'forceDelete')->name('posts.forceDestroy');
    });

    Route::resource('posts.comments', CommentController::class)->shallow()->only('store', 'edit', 'update', 'destroy');
    Route::group(['prefix' => 'comments', 'controller' => CommentController::class], function () {
        Route::patch('{comment}/restore', 'restore')->withTrashed()->name('comments.restore');
        Route::delete('{comment}/forceDestroy', 'forceDelete')->name('comments.forceDestroy');
    });

    Route::group(['prefix' => 'profile', 'middleware' => 'auth', 'controller' => ProfileController::class], function () {
        Route::get('edit', 'edit')->name('profile.edit');
        Route::get('{part?}', 'show')->where('part', '[a-z]+')->name('profile.show');
        Route::delete('', 'destroy')->middleware('password.confirm')->name('profile.destroy');
    });

    Route::group(['prefix' => 'users', 'controller' => UserController::class], function () {
        Route::get('', 'index')->name('users.index');
        Route::get('{user}/{part?}', 'show')->where('part', '[a-z]+')->name('users.show');
        Route::patch('{user}/assignModerator', 'assignModerator')->name('moderators.assign');
        Route::patch('{user}/removeModerator', 'removeModerator')->name('moderators.remove');
    });
});
