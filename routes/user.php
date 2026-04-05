<?php

use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\HomeController;
use Illuminate\Support\Facades\Route;

Route::controller(RegisterController::class)->group(function () {
    Route::get('register', 'showRegistrationForm')->name('register');
    Route::post('register', 'register')->name('register');
});



    Route::middleware('user')->group(function(){
        Route::controller(HomeController::class)->group(function () {
            Route::get('dashboard', 'dashboard')->name('dashboard');
            Route::post('logout', 'logout')->name('logout');
        });
    })







?>
