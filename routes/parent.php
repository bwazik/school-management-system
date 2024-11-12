<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale() . '/parent',
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:parent']
    ], function(){

    Route::get('dashboard', [App\Http\Controllers\Home2Controller::class, 'index'])->name('parent.dashboard');

});
