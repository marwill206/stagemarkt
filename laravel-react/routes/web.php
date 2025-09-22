<?php
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StudentSkillController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TextController;





Route::get('/', function () {
    return inertia('Home');
});


Route::get('/tristan', function () {
    return inertia('Tristan');
});



Route::get('/', [HomeController::class, 'index']);

Route::prefix('api')->group(function () {
    Route::apiResource('company', CompanyController::class);
});

Route::apiResource('studentskill', StudentSkillController::class);


Route::apiResource('skill', SkillController::class);

Route::apiResource('image', ImageController::class);

Route::apiResource('text', TextController::class);
