<?php

use App\Http\Controllers\User\ProfileController;
use Illuminate\Support\Facades\Route;



Route::prefix('profile')->name('profile.')->controller(ProfileController::class)->group(function(){
    Route::get('index','index')->name('index');
    Route::put('password/update','passwordUpdate')->name('password.update');
})





?>
