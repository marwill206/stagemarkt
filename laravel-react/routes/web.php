<?php
use App\Http\Controllers\AuthManager;
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

// Public routes
Route::get('/login', [AuthManager::class, 'login'])->name('login');
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::get('/register', [AuthManager::class, 'register'])->name('register');
Route::post('/register', [AuthManager::class, 'registerPost'])->name('register.post');

// Protected routes (require login)
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HeaderController::class, 'index'])->name('home');
    Route::get('/match', [MatchController::class, 'index'])->name('match.index');
    Route::post('/match/create', [MatchController::class, 'createMatch'])->name('match.create');
    Route::delete('/match/remove', [MatchController::class, 'removeMatch'])->name('match.remove');
    Route::get('/persona', function () {
        return inertia('persona');
    });
    Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');
});

// API Routes (also protected)
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::apiResource('companies', CompanyController::class);
    Route::apiResource('students', StudentController::class);
    Route::apiResource('professions', ProfessionController::class);
    Route::apiResource('schools', SchoolController::class);
    Route::apiResource('studentskills', StudentSkillController::class);
    Route::apiResource('skills', SkillController::class);
    Route::apiResource('images', ImageController::class);
    Route::apiResource('texts', TextController::class);
});

// Dashboard routes
Route::middleware(['auth'])->group(function () {
    Route::get('/student/dashboard', function() {
        return redirect()->route('home');
    })->name('student.dashboard');

    Route::get('/company/dashboard', function() {
        return redirect()->route('home');
    })->name('company.dashboard');
});
