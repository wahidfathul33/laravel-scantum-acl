<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;

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

//API route for register new user
Route::post('user/register', [UserController::class, 'register'])->name('user.register');
//API route for login user
Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login');

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('user/profile', [UserController::class, 'profile'])->name('user.profile')->middleware('role:admin');

    // API route for logout user
    Route::get('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
});