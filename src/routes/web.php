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
Route::get('/challenges/{id}', [TrailController::class, 'viewChallenge'])->middleware(['auth:team'])->whereNumber('id')->name('challenge');
Route::post('/challenges/{id}/submit', [TrailController::class, 'challengeSubmission'])->middleware(['auth:team'])->name('submit-challenge');

Route::match(['get', 'post'], '/login', [AdminController::class, 'login'])->middleware(['guest'])->name('login');
Route::get('/logout', [AdminController::class, 'logout'])->middleware(['auth:user'])->name('logout');

Route::prefix('dashboard')->middleware(['auth:user'])->controller(AdminController::class)->group(function(){
  Route::get('', 'dashboard')->name('dashboard');

  Route::get('/leaderboard', 'leaderboard')->name('leaderboard');

  Route::get('/submissions', 'submissions')->name('submissions');
  Route::post('/submission/{id}/accept', 'acceptSubmission')->whereNumber('id')->name('accept-submission');
  Route::match(['get', 'post'], '/submission/{id}/delete', 'deleteSubmission')->whereNumber('id')->name('delete-submission');

  Route::get('/questions', 'questions')->name('questions');
  Route::get('/question/{id}', 'viewQuestion')->whereNumber('id')->name('view-question');
  Route::get('/question/{id}/submissions', 'viewQuestionSubmissions')->whereNumber('id')->name('view-question-submissions');
  Route::match(['get', 'post'], '/question/new', 'addQuestion')->name('add-question');
  Route::match(['get', 'post'], '/question/{id}/edit', 'editQuestion')->whereNumber('id')->name('edit-question');
  Route::match(['get', 'post'], '/question/{id}/delete', 'deleteQuestion')->whereNumber('id')->name('delete-question');

  Route::get('/challenges', 'challenges')->name('challenges');
  Route::get('/challenge/{id}', 'viewChallenge')->whereNumber('id')->name('view-challenge');
  Route::get('/challenge/{id}/submissions', 'viewChallengeSubmissions')->whereNumber('id')->name('view-challenge-submissions');
  Route::match(['get', 'post'], '/challenge/new', 'addChallenge')->name('add-challenge');
  Route::match(['get', 'post'], '/challenge/{id}/edit', 'editChallenge')->whereNumber('id')->name('edit-challenge');
  Route::match(['get', 'post'], '/challenge/{id}/delete', 'deleteChallenge')->whereNumber('id')->name('delete-challenge');

  Route::get('/teams', 'teams')->name('teams');
  Route::get('/team/{id}/submissions', 'viewTeamSubmissions')->whereNumber('id')->name('view-team-submissions');
  Route::match(['get', 'post'], '/team/{id}/delete', 'deleteTeam')->whereNumber('id')->name('delete-team');

  Route::get('/groups', 'groups')->name('groups');
  Route::get('/group/{id}/teams', 'viewGroupTeams')->whereNumber('id')->name('view-group-teams');
  Route::match(['get', 'post'], '/group/new', 'addGroup')->name('add-group');
  Route::match(['get', 'post'], '/group/{id}/edit', 'editGroup')->whereNumber('id')->name('edit-group');
  Route::match(['get', 'post'], '/group/{id}/delete', 'deleteGroup')->whereNumber('id')->name('delete-group');
  
  Route::get('/users', 'users')->name('users');
  Route::match(['get', 'post'], '/user/new', 'addUser')->name('add-user');
  Route::match(['get', 'post'], '/user/{id}/edit', 'editUser')->whereNumber('id')->name('edit-user');
  Route::match(['get', 'post'], '/user/{id}/delete', 'deleteUser')->whereNumber('id')->name('delete-user');
  
  Route::match(['get', 'post'], '/settings', 'settings')->name('settings');
});
