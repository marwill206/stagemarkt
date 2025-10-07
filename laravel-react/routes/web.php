<?php
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\HeaderController;
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

// API Routes - All consolidated under /api prefix
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

Route::get('/', function() {
    return view('welcome');
})->name('home');


route::get('/login',[AuthManager::class, 'login'])->name('login');
route::post('/login',[AuthManager::class, 'loginPost'])->name('login.post');

route::get('/register', [AuthManager::class, 'register'])->name('register');
route::post('/register',[AuthManager::class, 'registerPost'])->name('register.post');