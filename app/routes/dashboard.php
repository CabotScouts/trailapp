<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\EventController;
use App\Http\Controllers\Dashboard\LeaderboardController;
use App\Http\Controllers\Dashboard\SubmissionController;
use App\Http\Controllers\Dashboard\QuestionController;
use App\Http\Controllers\Dashboard\ChallengeController;
use App\Http\Controllers\Dashboard\TeamController;
use App\Http\Controllers\Dashboard\GroupController;
use App\Http\Controllers\Dashboard\UserController;

Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->middleware(['guest'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->middleware(['auth:user'])->name('logout');

Route::prefix('dashboard')->middleware(['auth:user'])->group(function(){

  Route::controller(DashboardController::class)->group(function() {
    Route::get('', 'dashboard')->name('dashboard');
  });

  Route::controller(EventController::class)->group(function() {
    Route::get('/events', 'events')->name('events');
    Route::match(['get', 'post'], '/event/new', 'newEvent')->name('new-event');
    Route::match(['get', 'post'], '/event/{id}/edit', 'editEvent')->name('edit-event');
    Route::match(['get', 'post'], '/event/{id}/delete', 'deleteEvent')->name('delete-event');
    Route::match(['get', 'post'], '/event/{id}/active', 'toggleActive')->name('toggle-event-active');
    Route::match(['get', 'post'], '/event/{id}/running', 'toggleRunning')->name('toggle-event-running');
  });

  Route::controller(LeaderboardController::class)->group(function() {
    Route::get('/leaderboard/{group?}', 'leaderboard')->name('leaderboard');
  });

  Route::controller(SubmissionController::class)->group(function() {
    Route::get('/submissions/{filter?}/{page?}', 'submissions')->whereAlpha('filter')->name('submissions');
    Route::post('/submission/{id}/accept', 'acceptSubmission')->name('accept-submission');
    Route::post('/submission/{id}/reject', 'rejectSubmission')->name('reject-submission');
    Route::match(['get', 'post'], '/submission/{id}/delete', 'deleteSubmission')->name('delete-submission');
  });

  Route::controller(QuestionController::class)->group(function() {
    Route::get('/questions', 'questions')->name('questions');
    Route::get('/question/{id}', 'viewQuestion')->name('view-question');
    Route::get('/question/{id}/submissions', 'viewQuestionSubmissions')->name('view-question-submissions');
    Route::match(['get', 'post'], '/question/new', 'addQuestion')->name('add-question');
    Route::match(['get', 'post'], '/question/{id}/edit', 'editQuestion')->name('edit-question');
    Route::match(['get', 'post'], '/question/{id}/delete', 'deleteQuestion')->name('delete-question');
  });

  Route::controller(ChallengeController::class)->group(function() {
    Route::get('/challenges', 'challenges')->name('challenges');
    Route::get('/challenge/{id}', 'viewChallenge')->name('view-challenge');
    Route::get('/challenge/{id}/submissions', 'viewChallengeSubmissions')->name('view-challenge-submissions');
    Route::match(['get', 'post'], '/challenge/new', 'addChallenge')->name('add-challenge');
    Route::match(['get', 'post'], '/challenge/{id}/edit', 'editChallenge')->name('edit-challenge');
    Route::match(['get', 'post'], '/challenge/{id}/delete', 'deleteChallenge')->name('delete-challenge');
  });

  Route::controller(TeamController::class)->group(function() {
    Route::get('/teams', 'teams')->name('teams');
    Route::match(['get', 'post'], '/broadcast', 'broadcast')->name('broadcast');
    Route::match(['get', 'post'], '/team/{id}/broadcast', 'broadcast')->name('broadcast-to-team');
    Route::get('/team/{id}/submissions', 'viewTeamSubmissions')->name('view-team-submissions');
    Route::match(['get', 'post'], '/team/{id}/edit', 'editTeam')->name('edit-team');
    Route::match(['get', 'post'], '/team/{id}/delete', 'deleteTeam')->name('delete-team');
  });

  Route::controller(GroupController::class)->group(function() {
    Route::get('/groups', 'groups')->name('groups');
    Route::get('/group/{id}/teams', 'viewGroupTeams')->name('view-group-teams');
    Route::match(['get', 'post'], '/group/new', 'addGroup')->name('add-group');
    Route::match(['get', 'post'], '/group/{id}/edit', 'editGroup')->name('edit-group');
    Route::match(['get', 'post'], '/group/{id}/delete', 'deleteGroup')->name('delete-group');
  });

  Route::controller(UserController::class)->group(function() {
    Route::get('/users', 'users')->name('users');
    Route::match(['get', 'post'], '/user/new', 'addUser')->name('add-user');
    Route::match(['get', 'post'], '/user/{id}/edit', 'editUser')->name('edit-user');
    Route::match(['get', 'post'], '/user/{id}/delete', 'deleteUser')->name('delete-user');
  });
});
