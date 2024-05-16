<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/dropdown_store', [HomeController::class, 'store'])->name('dropdown_store');
Route::get('/options/get', [HomeController::class, 'getOptions'])->name('options.get');
