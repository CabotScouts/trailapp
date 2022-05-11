<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TeamController;
use App\Http\Controllers\TrailController;

Route::get('/', [TeamController::class, 'index'])->middleware(['checkteam'])->name('start');
Route::post('/create-team', [TeamController::class, 'create'])->name('create-team');
Route::get('/clone/{id}', [TeamController::class, 'clone']);
Route::get('/destroy', [TeamController::class, 'destroy'])->middleware(['auth:team']);

Route::get('/trail', [TrailController::class, 'index'])->middleware(['auth:team'])->name('trail');
Route::get('/challenges/{id}', [TrailController::class, 'viewChallenge'])->middleware(['auth:team'])->name('challenge');
Route::post('/challenges/{id}/submit', [TrailController::class, 'challengeSubmission'])->middleware(['auth:team'])->name('submit-challenge');
