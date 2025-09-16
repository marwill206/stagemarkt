<?php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Home');
});



Route::get('/', [HomeController::class, 'index']);