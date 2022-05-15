<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TeamController;
use App\Http\Controllers\TrailController;
use App\Http\Controllers\AdminController;

Route::get('/', [TeamController::class, 'index'])->middleware(['checkteam'])->name('start');
Route::post('/create-team', [TeamController::class, 'create'])->name('create-team');

Route::get('/clone/{id}', [TeamController::class, 'clone'])->middleware(['auth:user']);
Route::get('/destroy', [TeamController::class, 'destroy'])->middleware(['auth:user', 'auth:team']);

Route::get('/trail', [TrailController::class, 'index'])->middleware(['auth:team'])->name('trail');
Route::get('/challenges/{id}', [TrailController::class, 'viewChallenge'])->middleware(['auth:team'])->name('challenge');
Route::post('/challenges/{id}/submit', [TrailController::class, 'challengeSubmission'])->middleware(['auth:team'])->name('submit-challenge');

Route::match(['get', 'post'], '/login', [AdminController::class, 'login'])->middleware(['guest'])->name('login');
Route::get('/logout', [AdminController::class, 'logout'])->middleware(['auth:user'])->name('logout');
Route::get('/dashboard', [AdminController::class, 'dashboard'])->middleware(['auth:user'])->name('dashboard');
