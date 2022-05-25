<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TeamController;
use App\Http\Controllers\TrailController;
use App\Http\Controllers\AdminController;

Route::get('/', [TeamController::class, 'index'])->middleware(['checkteam'])->name('start');
Route::post('/create-team', [TeamController::class, 'create'])->name('create-team');
Route::get('/join/{id}/{code}', [TeamController::class, 'join'])->middleware(['checkteam'])->name('join-team');
Route::get('/clone/{id}', [TeamController::class, 'clone'])->middleware(['auth:user']);
Route::get('/destroy', [TeamController::class, 'destroy'])->middleware(['auth:user', 'auth:team']);

Route::middleware(['auth:team'])->controller(TrailController::class)->group(function() {
  Route::get('/trail', 'questions')->name('trail');
  Route::get('/question/{id}', 'viewQuestion')->name('question');
  Route::post('/question/{id}/submit', 'questionSubmission')->name('submit-question');

  Route::get('/challenges', 'challenges')->name('trail-challenges');
  Route::get('/challenge/{id}', 'viewChallenge')->name('challenge');
  Route::post('/challenge/{id}/submit', 'challengeSubmission')->name('submit-challenge');
  
  Route::get('/qr', 'showQR')->name('show-qr');
  Route::get('/qr/code.png', 'getQRImage')->name('qr-image');
});

Route::match(['get', 'post'], '/login', [AdminController::class, 'login'])->middleware(['guest'])->name('login');
Route::get('/logout', [AdminController::class, 'logout'])->middleware(['auth:user'])->name('logout');

Route::prefix('dashboard')->middleware(['auth:user'])->controller(AdminController::class)->group(function(){
  Route::get('', 'dashboard')->name('dashboard');
  Route::match(['get', 'post'], '/broadcast', 'broadcast')->name('broadcast');
  Route::get('/leaderboard', 'leaderboard')->name('leaderboard');

  Route::get('/submissions/{filter?}/{page?}', 'submissions')->whereAlpha('filter')->name('submissions');
  Route::post('/submission/{id}/accept', 'acceptSubmission')->name('accept-submission');
  Route::post('/submission/{id}/reject', 'rejectSubmission')->name('reject-submission');
  Route::match(['get', 'post'], '/submission/{id}/delete', 'deleteSubmission')->name('delete-submission');

  Route::get('/questions', 'questions')->name('questions');
  Route::get('/question/{id}', 'viewQuestion')->name('view-question');
  Route::get('/question/{id}/submissions', 'viewQuestionSubmissions')->name('view-question-submissions');
  Route::match(['get', 'post'], '/question/new', 'addQuestion')->name('add-question');
  Route::match(['get', 'post'], '/question/{id}/edit', 'editQuestion')->name('edit-question');
  Route::match(['get', 'post'], '/question/{id}/delete', 'deleteQuestion')->name('delete-question');

  Route::get('/challenges', 'challenges')->name('challenges');
  Route::get('/challenge/{id}', 'viewChallenge')->name('view-challenge');
  Route::get('/challenge/{id}/submissions', 'viewChallengeSubmissions')->name('view-challenge-submissions');
  Route::match(['get', 'post'], '/challenge/new', 'addChallenge')->name('add-challenge');
  Route::match(['get', 'post'], '/challenge/{id}/edit', 'editChallenge')->name('edit-challenge');
  Route::match(['get', 'post'], '/challenge/{id}/delete', 'deleteChallenge')->name('delete-challenge');

  Route::get('/teams', 'teams')->name('teams');
  Route::match(['get', 'post'], '/team/{id}/broadcast', 'broadcast')->name('broadcast-to-team');
  Route::get('/team/{id}/submissions', 'viewTeamSubmissions')->name('view-team-submissions');
  Route::match(['get', 'post'], '/team/{id}/delete', 'deleteTeam')->name('delete-team');

  Route::get('/groups', 'groups')->name('groups');
  Route::get('/group/{id}/teams', 'viewGroupTeams')->name('view-group-teams');
  Route::match(['get', 'post'], '/group/new', 'addGroup')->name('add-group');
  Route::match(['get', 'post'], '/group/{id}/edit', 'editGroup')->name('edit-group');
  Route::match(['get', 'post'], '/group/{id}/delete', 'deleteGroup')->name('delete-group');

  Route::get('/users', 'users')->name('users');
  Route::match(['get', 'post'], '/user/new', 'addUser')->name('add-user');
  Route::match(['get', 'post'], '/user/{id}/edit', 'editUser')->name('edit-user');
  Route::match(['get', 'post'], '/user/{id}/delete', 'deleteUser')->name('delete-user');

  Route::match(['get', 'post'], '/settings', 'settings')->name('settings');
});
