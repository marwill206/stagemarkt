<?php
use App\Http\Controllers\AuthManager;

use App\Http\Controllers\HeaderController;
use Illuminate\Auth\Events\Logout;
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

Route::get('/', function() {
    return view('app');
})->name('home');

App\Providers\AuthServiceProvider::class;

Route::get('/login',[AuthManager::class, 'login'])->name('login');
Route::post('/login',[AuthManager::class, 'loginPost'])->name('login.post');

Route::get('/register', [AuthManager::class, 'register'])->name('register');
Route::post('/register',[AuthManager::class, 'registerPost'])->name('register.post');
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

// routes/web.php
Route::get('/student/dashboard', function() {
    return view('student.dashboard');
})->name('student.dashboard');

Route::get('/company/dashboard', function() {
    return view('company.dashboard');
})->name('company.dashboard');
