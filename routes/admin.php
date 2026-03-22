<?php

use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\DriveSettingsController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Support\Facades\Route;


Route::controller(RegisterController::class)->group(function(){
    Route::get('registration','showRegistrationForm')->name('registration');
    Route::post('register/submit','register')->name('register');
});


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
    Route::get('test/connection', 'testConnection')->name('test.connection');


    Route::post('upload/file','fileUpload')->name('upload.file');
    Route::delete('delete/file','fileDelete')->name('delete.file');
    Route::get('download/file/{file_name}','downloadFile')->name('download.file');
    Route::get('view/file/{filename}', 'viewFile')->name('view.file');

});





?>
