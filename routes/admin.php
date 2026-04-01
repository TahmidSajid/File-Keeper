<?php

use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\DriveSettingsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;




Route::controller(RegisterController::class)->group(function () {
    Route::get('register', 'showRegistrationForm')->name('register');
    Route::post('register', 'register')->name('register');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login')->name('login');
});

Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('password/request', 'showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'sendResetLinkEmail')->name('password.email');
});

Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    Route::post('password/update', 'reset')->name('password.update');
});


Route::middleware('admin')->group(function(){

    Route::controller(HomeController::class)->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::post('logout', 'logout')->name('logout');
    });

    Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function () {
        Route::get('index','index')->name('index');
        Route::put('update','update')->name('update');
        Route::put('password/update','passwordUpdate')->name('password.update');
    });

    Route::prefix('drive')->name('drive.')->controller(DriveSettingsController::class)->group(function(){
        Route::get('index','index')->name('index');
        Route::post('update','update')->name('update');
        Route::get('redirect/google','redirectToGoogle')->name('redirect.google');
        Route::get('handle/callback','handleGoogleCallback')->name('handle.callback');
        Route::get('test/connection', 'testConnection')->name('test.connection');


        Route::post('upload/file','fileUpload')->name('upload.file');
        Route::delete('delete/file','fileDelete')->name('delete.file');
        Route::get('download/file/{file_name}','downloadFile')->name('download.file');
        Route::get('view/file/{filename}', 'viewFile')->name('view.file');

    });

});


