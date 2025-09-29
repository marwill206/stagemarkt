<?php
use App\Http\Controllers\HeaderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StudentSkillController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\TextController;
use App\Http\Controllers\AuthController;





Route::get('/', function () {
    return inertia('header');
});


Route::get('/persona', function () {
    return inertia('persona');
});



Route::get('/', [HeaderController::class, 'index']);

Route::prefix('api')->group(function () {
    Route::apiResource('company', CompanyController::class);
});

Route::apiResource('studentskill', StudentSkillController::class);


Route::apiResource('skill', SkillController::class);

Route::apiResource('image', ImageController::class);

Route::apiResource('text', TextController::class);


Route::get('/register', [AuthController::class, 'showRegister'])->name('show.register');
Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});