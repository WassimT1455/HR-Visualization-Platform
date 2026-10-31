<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CongeController;
use App\Http\Controllers\ConnexionController;
use App\Http\Controllers\CoverController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/cover');
Route::get('/cover', [CoverController::class, 'index'])->name('cover');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');
Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signupPost'])->name('signup.post');

/*
|--------------------------------------------------------------------------
| Authenticated users (employees and admins)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');

    // Leaves
    Route::get('/mes-conges', [CongeController::class, 'myConges'])->name('conges.my');
    Route::get('/conges', [CongeController::class, 'myConges'])->name('conges.index');
    Route::get('/conges/create', [CongeController::class, 'create'])->name('conges.create');
    Route::post('/conges', [CongeController::class, 'store'])->name('conges.store');

    // Missions
    Route::get('/mes-missions', [MissionController::class, 'myMissions'])->name('missions.my');

    // Login history
    Route::get('/dashboard/connexions', [ConnexionController::class, 'showUserConnexions'])->name('dashboard.connexions');
    Route::get('/connexions', [ConnexionController::class, 'showUserConnexions'])->name('connexions.index');

    // ML prediction (rate limited)
    Route::get('/prediction', [AuthController::class, 'showPredictionForm'])->name('predict.connexion.form');
    Route::post('/prediction', [AuthController::class, 'predictConnexion'])
        ->middleware('throttle:20,1')
        ->name('predict.connexion');
});

/*
|--------------------------------------------------------------------------
| Administrators only (authentication AND admin role)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    Route::post('/admin/{user}/conge/add', [AdminController::class, 'addConge'])->name('admin.addConge');
    Route::delete('/admin/conge/{id}/delete', [AdminController::class, 'deleteConge'])->name('admin.deleteConge');

    Route::post('/admin/{user}/mission/add', [AdminController::class, 'addMission'])->name('admin.addMission');
    Route::delete('/admin/mission/{id}/delete', [AdminController::class, 'deleteMission'])->name('admin.deleteMission');

    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.delete');
});