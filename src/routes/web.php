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

Route::prefix('dashboard')->middleware(['auth:user'])->controller(AdminController::class)->group(function(){
  Route::get('', 'dashboard')->name('dashboard');

  Route::get('/submissions', 'submissions')->name('submissions');
  Route::post('/submission/{id}/accept', 'acceptSubmission')->name('accept-submission');
  Route::match(['get', 'post'], '/submission/{id}/delete', 'deleteSubmission')->name('delete-submission');

  Route::get('/teams', 'teams')->name('teams');
  Route::get('/team/{id}/submissions', 'viewTeamSubmissions')->name('view-team-submissions');
  Route::match(['get', 'post'], '/team/{id}/delete', 'deleteTeam')->name('delete-team');

  Route::get('/challenges', 'challenges')->name('challenges');
  Route::get('/challenge/{id}', 'viewChallenge')->name('view-challenge');
  Route::get('/challenge/{id}/submissions', 'viewChallengeSubmissions')->name('view-challenge-submissions');
  Route::match(['get', 'post'], '/challenge/new', 'addChallenge')->name('add-challenge');
  Route::match(['get', 'post'], '/challenge/{id}/edit', 'editChallenge')->name('edit-challenge');
  Route::match(['get', 'post'], '/challenge/{id}/delete', 'deleteChallenge')->name('delete-challenge');

  Route::get('/groups', 'groups')->name('groups');
  Route::get('/group/{id}/teams', 'viewGroupTeams')->name('view-group-teams');
  Route::match(['get', 'post'], '/group/new', 'addGroup')->name('add-group');
  Route::match(['get', 'post'], '/group/{id}/edit', 'editGroup')->name('edit-group');
  Route::match(['get', 'post'], '/group/{id}/delete', 'deleteGroup')->name('delete-group');
});
