<?php

use App\Http\Controllers\User\DriveSettingsController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;



Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function(){
    Route::get('index','index')->name('index');
    Route::put('update','update')->name('update');
    Route::put('password/update','passwordUpdate')->name('password.update');
});


Route::prefix('drive')->name('drive.')->controller(DriveSettingsController::class)->group(function(){
    Route::get('index','index')->name('index');
    Route::post('update','update')->name('update');
    Route::get('redirect/google','redirectToGoogle')->name('redirect.google');
    Route::get('handle/callback','handleGoogleCallback')->name('handle.callback');


    Route::post('upload/file','fileUpload')->name('upload.file');
});





?>
