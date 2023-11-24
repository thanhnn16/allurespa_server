<?php

use App\Http\Controllers\CosmeticController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TreatmentController;
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

Route::get('treatments', [TreatmentController::class, 'index']);
Route::get('treatments/{id}', [TreatmentController::class, 'show']);

Route::get('cosmetics', [CosmeticController::class, 'index']);
Route::get('cosmetics/{id}', [CosmeticController::class, 'show']);

Route::post('/login-get-token', [LoginController::class, 'loginGetToken'])->middleware('api')->name('login.get.token');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });




});
