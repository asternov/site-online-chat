<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::get('/chat', [App\Http\Controllers\MessagesController::class, 'index']);
});

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/chat', [App\Http\Controllers\MessagesController::class, 'index']);
Route::post('/author/check', [App\Http\Controllers\AuthorController::class, 'check']);
Route::post('/author/delete', [App\Http\Controllers\AuthorController::class, 'delete']);
Route::get('/widget', [App\Http\Controllers\MessagesController::class, 'widget']);
Route::get('/messages', [App\Http\Controllers\MessagesController::class, 'fetchMessages']);
Route::post('/messages', [App\Http\Controllers\MessagesController::class, 'sendMessage']);
Route::delete('/messages/{message}', [App\Http\Controllers\MessagesController::class, 'destroy']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
