<?php

use App\Http\Controllers\HeaderController;
use App\Http\Controllers\MatchController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\database\CompanyController;
use App\Http\Controllers\database\StudentController;
use App\Http\Controllers\database\ProfessionController;
use App\Http\Controllers\database\SchoolController;
use App\Http\Controllers\database\StudentSkillController;
use App\Http\Controllers\database\SkillController;
use App\Http\Controllers\database\ImageController;
use App\Http\Controllers\database\TextController;

// Main pages
Route::get('/', [HeaderController::class, 'index']);
Route::get('/persona', function () {
    return inertia('persona');
});

// Match routes
Route::get('/match', [MatchController::class, 'index'])->name('match.index');
Route::post('/match/create', [MatchController::class, 'createMatch'])->name('match.create');
Route::delete('/match/remove', [MatchController::class, 'removeMatch'])->name('match.remove');

// API Routes
Route::prefix('api')->group(function () {
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('students', StudentController::class);
    Route::apiResource('professions', ProfessionController::class);
    Route::apiResource('schools', SchoolController::class);
    Route::apiResource('studentskills', StudentSkillController::class);
    Route::apiResource('skills', SkillController::class);
    Route::apiResource('images', ImageController::class);
    Route::apiResource('texts', TextController::class);
});
