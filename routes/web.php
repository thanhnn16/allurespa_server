<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\CosmeticController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');
Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
Route::get('/dashboard', [HomeController::class, 'index'])->name('home')->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

//    route for user management
    Route::get('/user-management', [UserController::class, 'index'])->name('user-management');
    Route::get('/user-management/{id}', [UserController::class, 'show'])->name('user-management.show');
    Route::get('/user-management-create', [UserController::class, 'create'])->name('user-management.create');
    Route::post('/user-management-create', [UserController::class, 'store'])->name('user-management.store');
    Route::delete('/user-management/{id}', [UserController::class, 'delete'])->name('user-management.delete');
    Route::post('/user-management/delete-selected', [UserController::class, 'deleteSelected'])->name('user-management.delete-selected');
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    Route::get('users/template', [UserController::class, 'template'])->name('users.template');
    Route::post('users/import', [UserController::class, 'import'])->name('users.import');
    Route::post('/user-image-upload', [ImageController::class, 'userImageUpload'])->name('user.image.upload');

//    route for treatment management
    Route::get('/treatment-management', [TreatmentController::class, 'index'])->name('treatment-management');
    Route::get('/treatment-management/{id}', [TreatmentController::class, 'show'])->name('treatment-management.show');
    Route::get('/treatment-management-create', [TreatmentController::class, 'create'])->name('treatment-management.create');
    Route::post('/treatment-management-create', [TreatmentController::class, 'store'])->name('treatment-management.store');
    Route::delete('/treatment-management/{id}', [TreatmentController::class, 'delete'])->name('treatment-management.delete');
    Route::post('/treatment-management/delete-selected', [TreatmentController::class, 'deleteSelected'])->name('treatment-management.delete-selected');
    Route::get('treatment/export', [TreatmentController::class, 'export'])->name('treatment.export');
    Route::get('treatment/template', [TreatmentController::class, 'template'])->name('treatment.template');
    Route::post('treatment/import', [TreatmentController::class, 'import'])->name('treatment.import');
    Route::post('/treatment-image-upload', [ImageController::class, 'treatmentImageUpload'])->name('treatment.image.upload');


//    route for cosmetic management
    Route::get('/cosmetic-management', [CosmeticController::class, 'index'])->name('cosmetic-management');
    Route::get('/cosmetic-management/{id}', [CosmeticController::class, 'show'])->name('cosmetic-management.show');
    Route::get('/cosmetic-management-create', [CosmeticController::class, 'create'])->name('cosmetic-management.create');
    Route::post('/cosmetic-management-create', [CosmeticController::class, 'store'])->name('cosmetic-management.store');
    Route::delete('/cosmetic-management/{id}', [CosmeticController::class, 'delete'])->name('cosmetic-management.delete');
    Route::post('/cosmetic-management/delete-selected', [CosmeticController::class, 'deleteSelected'])->name('cosmetic-management.delete-selected');
    Route::get('cosmetic/export', [CosmeticController::class, 'export'])->name('cosmetic.export');
    Route::get('cosmetic/template', [CosmeticController::class, 'template'])->name('cosmetic.template');
    Route::post('cosmetic/import', [CosmeticController::class, 'import'])->name('cosmetic.import');
    Route::post('/cosmetic-image-upload', [ImageController::class, 'cosmeticImageUpload'])->name('cosmetic.image.upload');

//    route for appointment
    Route::get('/appointment-management', [AppointmentController::class, 'index'])->name('appointment-management');
    Route::get('/appointment-management/{id}', [AppointmentController::class, 'show'])->name('appointment-management.show');
    Route::get('/appointment-management-create', [AppointmentController::class, 'create'])->name('appointment-management.create');
    Route::post('/appointment-management', [AppointmentController::class, 'calendarEvents'])->name('appointment-management.store');

//    route for home
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::get('/chat', [PageController::class, 'chat'])->name('chat');
    Route::get('/{page}', [PageController::class, 'index'])->name('page');
});

Route::group(['middleware' => 'api'], function () {
    Route::resource('treatment', TreatmentController::class);
    Route::resource('cosmetic', CosmeticController::class);
    Route::resource('appointment', AppointmentController::class);
});
