<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', [App\Http\Controllers\Auth\LoginController::class,'showLoginForm'])->name('showLoginForm');


Route::group(['prefix'=>'admin', 'middleware'=>'auth'],function($route){
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/alunos/etiquetas', [App\Http\Controllers\KidController::class, 'tag'])->name('admin.kid.tag');
    Route::resource('/alunos', App\Http\Controllers\KidController::class)->names('admin.kid');
    Route::resource('/turmas', App\Http\Controllers\KidClassController::class)->names('admin.kid.class');
});
