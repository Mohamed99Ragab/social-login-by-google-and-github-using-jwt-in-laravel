<?php

use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//auth login to admin guard

Route::get('login/admin',[AdminAuthController::class,'AdminLogin'])->name('admin.login');
Route::post('login/admin',[AdminAuthController::class,'AdminLoginCheck'])->name('admin.auth.check');

Route::get('admin',[HomeController::class,'admin'])->middleware('auth:admin')->name('admin.dashboard');
// end auth login to admin guard




Route::get('/home', [HomeController::class, 'index'])->middleware('auth:web')->name('home');


Route::get('/auth/redirect', [LoginController::class,'github_redirect'])->name('github.auth.redirect');

Route::get('/auth/callback', [LoginController::class,'github_callback'])->name('github.auth.callback');


