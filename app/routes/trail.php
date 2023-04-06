<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TeamController;
use App\Http\Controllers\TrailController;

Route::get('/', [TeamController::class, 'index'])->middleware(['check_team'])->name('start');
Route::post('/create-team', [TeamController::class, 'create'])->name('create-team');
Route::get('/join/{id}/{code}', [TeamController::class, 'join'])->middleware(['check_team'])->name('join-team');
Route::get('/clone/{id}', [TeamController::class, 'clone'])->middleware(['auth:user']);
Route::get('/destroy', [TeamController::class, 'destroy'])->middleware(['auth:user', 'auth:team']);

Route::middleware(['auth:team', 'valid_event'])->controller(TrailController::class)->group(function() {
  Route::get('/trail', 'questions')->name('trail');
  Route::get('/question/{id}', 'viewQuestion')->name('question');
  Route::post('/question/{id}/submit', 'questionSubmission')->name('submit-question');

  Route::get('/challenges', 'challenges')->name('trail-challenges');
  Route::get('/challenge/{id}', 'viewChallenge')->name('challenge');
  Route::post('/challenge/{id}/submit', 'challengeSubmission')->name('submit-challenge');
  
  Route::get('/qr', 'showQR')->name('show-qr');
  Route::get('/qr/code.png', 'getQRImage')->name('qr-image');
});
