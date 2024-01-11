<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiRestaurantController;
use App\Http\Controllers\Api\ApiGenreController;
use App\Http\Controllers\Api\ApiMenuController;
use App\Http\Controllers\Api\ApiReviewController;
use App\Http\Controllers\Api\ApiBookmarkController;
use App\Http\Controllers\Api\ApiAuthUserController;
use App\Http\Controllers\Api\ApiAuthOwnerController;
use App\Http\Controllers\Api\ApiAuthAdminController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Genre
Route::get('genres', [ApiGenreController::class, 'index']);
Route::post('genres/store', [ApiGenreController::class, 'store'])->middleware('auth:admin');
Route::post('genres/update/{genre}', [ApiGenreController::class, 'update'])->middleware('auth:admin');
Route::post('genres/delete/{genre}', [ApiGenreController::class, 'destroy'])->middleware('auth:admin');

Route::get('restaurants', [ApiRestaurantController::class, 'index']);
Route::post('restaurants/store', [ApiRestaurantController::class, 'store'])->middleware('auth:owner');
Route::post('restaurants/update/{restaurant}', [ApiRestaurantController::class, 'update'])->middleware('auth:owner,admin');
Route::post('restaurants/delete/{restaurant}', [ApiRestaurantController::class, 'destroy'])->middleware('auth:owner,admin');

Route::post('restaurants/keyword', [ApiRestaurantController::class, 'searchRestaurants']);
Route::post('restaurants/nearby', [ApiRestaurantController::class, 'nearbyRestaurants']);

Route::get('menus', [ApiMenuController::class, 'index']);
Route::post('menus/store/{restaurant}', [ApiMenuController::class, 'store'])->middleware('auth:owner,admin');
Route::post('menus/update/{menu}', [ApiMenuController::class, 'update'])->middleware('auth:owner,admin');
Route::post('menus/delete/{menu}', [ApiMenuController::class, 'destroy'])->middleware('auth:owner,admin');

Route::get('reviews', [ApiReviewController::class, 'index']);
Route::post('reviews/store/{restaurant}', [ApiReviewController::class, 'store'])->middleware('auth:web');
Route::post('reviews/update/{review}', [ApiReviewController::class, 'update'])->middleware('auth:web,admin');
Route::post('reviews/delete/{review}', [ApiReviewController::class, 'destroy'])->middleware('auth:web,admin');

Route::post('isBookmark/{restaurant}', [ApiBookmarkController::class, 'isBookmark'])->middleware('auth:web');
Route::post('bookmark/{restaurant}', [ApiBookmarkController::class, 'bookmark'])->middleware('auth:web');


Route::get('/auth', function () {
    if(Auth::guard('web')->check()) {
        return response()->json([
            'message' => 'Authenticated.',
            'auth' => Auth::guard('web')->user(),
            'guard' => 'user',
        ]);
    } elseif(Auth::guard('owner')->check()) {
        return response()->json([
            'message' => 'Authenticated.',
            'auth' => Auth::guard('owner')->user(),
            'guard' => 'owner',
        ]);
    } elseif(Auth::guard('admin')->check()) {
        return response()->json([
            'message' => 'Authenticated.',
            'auth' => Auth::guard('admin')->user(),
            'guard' => 'admin',
        ]);
    } else {
        return response()->json([
            'message' => 'UnAuthenticated.',
            'auth' => '' ,
        ]);
    }
});

Route::post('user/register', [ApiAuthUserController::class, 'register']);
Route::post('user/login', [ApiAuthUserController::class, 'login']);
Route::post('user/logout', [ApiAuthUserController::class, 'logout'])->middleware('auth:web');

Route::post('owner/register', [ApiAuthOwnerController::class, 'register']);
Route::post('owner/login', [ApiAuthOwnerController::class, 'login']);
Route::post('owner/logout', [ApiAuthOwnerController::class, 'logout'])->middleware('auth:owner');

// Route::post('admin/register', [ApiAuthAdminController::class, 'register']);
Route::post('admin/login', [ApiAuthAdminController::class, 'login']);
Route::post('admin/logout', [ApiAuthAdminController::class, 'logout'])->middleware('auth:admin');

