<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CosmeticController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\UserController;
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

Route::get('treatments', [TreatmentController::class, 'index'])->middleware('json.response');
Route::get('treatments/{id}', [TreatmentController::class, 'show'])->middleware('json.response');

Route::get('cosmetics', [CosmeticController::class, 'index'])->middleware('json.response');
Route::get('cosmetics-best', [CosmeticController::class, 'getTopCosmetics'])->middleware('json.response');
Route::get('cosmetics/{id}', [CosmeticController::class, 'show'])->middleware('json.response');

Route::get('search', [SearchController::class, 'index'])->middleware('json.response');

Route::post('/login-get-token', [LoginController::class, 'loginGetToken'])->middleware('api')->name('login.get.token');
Route::post('/register', [RegisterController::class, 'registerGetToken'])->middleware('api')->name('register.get.token');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('user/{id}', [UserController::class, 'show'])->middleware('json.response');
    Route::put('user/{id}', [UserController::class, 'updateFromClient'])->middleware('json.response');

    Route::get('appointments', [AppointmentController::class, 'index'])->middleware('json.response');
    Route::get('appointments/{id}', [AppointmentController::class, 'show'])->middleware('json.response');
    Route::post('appointment-management', [AppointmentController::class, 'calendarEvents'])->middleware('json.response');

//    Route::get('messages', [ChatController::class, 'index'])->middleware('json.response');
    Route::get('messages/{userId}', [ChatController::class, 'getMsgToClient'])->middleware('json.response');
    Route::post('messages', [ChatController::class, 'sendMsgFromClient'])->middleware('json.response');


});
