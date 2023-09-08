<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\BaiVietController;

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



// truyền /index về giao diện
Route::get ('/', [IndexController::class, 'show']) -> name('home');
// truyền chi tiết bài posts
Route::get('post/{post}',[IndexController::class, 'show1']);
// truyền chi tiết giới thiệu clb
Route::get('gioithieu/{gioithieu}',[IndexController::class, 'gioithieu']);
//search
Route::get('/search',[IndexController::class,'search'])-> name('HOME1');


