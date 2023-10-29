<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User Route
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::get('login/check', [UserController::class, 'loginCheck']);
Route::post('logout', [UserController::class, 'logout']);
Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'profile']);
Route::put('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'destroy']);


// Category Route Resource
Route::resource('categories', CategoryController::class);

// Article Route Resource
Route::resource('articles', ArticleController::class);

// Media Route Resource
Route::resource('media', MediaController::class);

// Portfolio Route Resource
Route::resource('portfolios', PortfolioController::class);

// Comment Route Resource
Route::resource('comments', CommentController::class);
