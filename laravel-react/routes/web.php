<?php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;


Route::get('/', function () {
    return inertia('Home');
});



Route::get('/', [HomeController::class, 'index']);

Route::prefix('api')->group(function () {
    Route::apiResource('company', CompanyController::class);
});