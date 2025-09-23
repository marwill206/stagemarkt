<?php
use App\Http\Controllers\database\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\database\CompanyController;
use App\Http\Controllers\database\StudentSkillController;
use App\Http\Controllers\database\SkillController;
use App\Http\Controllers\database\ImageController;
use App\Http\Controllers\database\TextController;




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
