<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\MenuController;

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

Route::get('/', [RestaurantController::class, 'index'])->name('index');

Route::get('/user', [RestaurantController::class, 'index'])->middleware('auth:web')->name('user-home');

Auth::routes();

Route::get('/login/owner', [App\Http\Controllers\Auth\LoginController::class, 'showOwnerLoginForm']);
Route::get('/register/owner', [App\Http\Controllers\Auth\RegisterController::class, 'showOwnerRegisterForm']);

Route::post('/login/owner', [App\Http\Controllers\Auth\LoginController::class, 'ownerLogin']);
Route::post('/register/owner', [App\Http\Controllers\Auth\RegisterController::class, 'registerOwner'])->name('owner-register');

Route::get('/owner', [RestaurantController::class, 'index'])->middleware('auth:owner')->name('owner-home');

Route::get('password/owner/reset', [App\Http\Controllers\Auth\OwnerForgotPasswordController::class, 'showLinkRequestForm'])->name('owner.password.request');
Route::post('password/owner/email', [App\Http\Controllers\Auth\OwnerForgotPasswordController::class, 'sendResetLinkEmail'])->name('owner.password.email');
Route::get('password/owner/reset/{token}', [App\Http\Controllers\Auth\OwnerResetPasswordController::class, 'showResetForm'])->name('owner.password.reset');
Route::post('password/owner/reset', [App\Http\Controllers\Auth\OwnerResetPasswordController::class, 'reset'])->name('owner.password.update');

Route::get('/login/admin', [App\Http\Controllers\Auth\LoginController::class, 'showAdminLoginForm']);
    Route::get('/register/admin', [App\Http\Controllers\Auth\RegisterController::class, 'showAdminRegisterForm']);

Route::post('/login/admin', [App\Http\Controllers\Auth\LoginController::class, 'adminLogin']);
    Route::post('/register/admin', [App\Http\Controllers\Auth\RegisterController::class, 'registerAdmin'])->name('admin-register');

Route::get('/admin', [RestaurantController::class, 'index'])->middleware('auth:admin')->name('admin-home');

Route::get('password/admin/reset', [App\Http\Controllers\Auth\AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
Route::post('password/admin/email', [App\Http\Controllers\Auth\AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
Route::get('password/admin/reset/{token}', [App\Http\Controllers\Auth\AdminResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');
Route::post('password/admin/reset', [App\Http\Controllers\Auth\AdminResetPasswordController::class, 'reset'])->name('admin.password.update');


Route::get('/owner/create', [RestaurantController::class, 'create'])->middleware('auth:owner')->name('owner.create');
Route::post('/owner/store', [RestaurantController::class, 'store'])->middleware('auth:owner')->name('owner.store');

Route::get('/show/{restaurant}', [RestaurantController::class, 'show'])->name('show');
Route::get('/user/show/{restaurant}', [RestaurantController::class, 'show'])->middleware('auth:web')->name('user.show');
Route::get('/owner/show/{restaurant}', [RestaurantController::class, 'show'])->middleware('auth:owner')->name('owner.show');
Route::get('/admin/show/{restaurant}', [RestaurantController::class, 'show'])->middleware('auth:admin')->name('admin.show');

Route::get('/owner/mypage', [RestaurantController::class, 'showOwnerMypage'])->middleware('auth:owner')->name('owner.mypage');
Route::get('/user/mypage', [RestaurantController::class, 'showUserMypage'])->middleware('auth:web')->name('user.mypage');

Route::get('/owner/edit/{restaurant}', [RestaurantController::class, 'edit'])->middleware('auth:owner')->name('owner.edit');
Route::post('/owner/update/{restaurant}', [RestaurantController::class, 'update'])->middleware('auth:owner')->name('owner.update');

Route::post('/owner/delete/{restaurant}', [RestaurantController::class, 'destroy'])->middleware('auth:owner')->name('owner.delete');

Route::get('/admin/edit/{restaurant}', [RestaurantController::class, 'edit'])->middleware('auth:admin')->name('admin.edit');
Route::post('/admin/update/{restaurant}', [RestaurantController::class, 'update'])->middleware('auth:admin')->name('admin.update');

Route::post('/admin/delete/{restaurant}', [RestaurantController::class, 'destroy'])->middleware('auth:admin')->name('admin.delete');

Route::post('/user/createReview/{restaurant}', [ReviewController::class, 'store'])->middleware('auth:web')->name('user.create-review');
Route::post('/updateReview/{review}/{restaurant}', [ReviewController::class, 'update'])->name('update-review');
Route::post('/deleteReview/{review}/{restaurant}', [ReviewController::class, 'destroy'])->name('delete-review');

Route::post('/user/bookmark/{restaurant}', [RestaurantController::class, 'bookmark'])->name('user.bookmark');

Route::get('/admin/genres', [GenreController::class, 'index'])->middleware('auth:admin')->name('genres.index');
Route::post('/admin/genres/store', [GenreController::class, 'store'])->middleware('auth:admin')->name('genres.store');
Route::post('/admin/genres/update/{genre}', [GenreController::class, 'update'])->middleware('auth:admin')->name('genres.update');
Route::post('/admin/genres/delete/{genre}', [GenreController::class, 'destroy'])->middleware('auth:admin')->name('genres.delete');

Route::post('/menu/store/{restaurant}', [MenuController::class, 'store'])->name('menu.store');
Route::post('/menu/update/{menu}', [MenuController::class, 'update'])->name('menu.update');
Route::post('/menu/delete/{menu}', [MenuController::class, 'destroy'])->name('menu.delete');