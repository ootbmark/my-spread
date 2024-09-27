<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);
Route::get('/logout', function (){
    abort(404);
});
Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider')->name('auth.redirect');
Route::get('/api/login/{provider}/callback', 'Auth\AuthController@handleProviderCallback')->name('auth.callback');

Route::post('/activity', [App\Http\Controllers\HomeController::class, 'activity'])->name('activity');
Route::get('/linkedin', [App\Http\Controllers\HomeController::class, 'linkedin'])->name('linkedin');
