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

Route::get('/submissions', [AdminController::class, 'submissions'])->middleware(['auth:user'])->name('submissions');
Route::get('/submission/{id}', [AdminController::class, 'viewSubmission'])->middleware(['auth:user'])->name('view-submission');
Route::get('/submission/{id}/accept', [AdminController::class, 'acceptSubmission'])->middleware(['auth:user'])->name('accept-submission');
Route::get('/submission/{id}/delete', [AdminController::class, 'deleteSubmission'])->middleware(['auth:user'])->name('delete-submission');

Route::get('/teams', [AdminController::class, 'teams'])->middleware(['auth:user'])->name('teams');
Route::get('/team/{id}', [AdminController::class, 'viewTeam'])->middleware(['auth:user'])->name('view-team');
Route::match(['get', 'post'], '/team/{id}/delete', [AdminController::class, 'deleteTeam'])->middleware(['auth:user'])->name('delete-team');

Route::get('/challenges', [AdminController::class, 'challenges'])->middleware(['auth:user'])->name('challenges');
Route::get('/challenge/{id}', [AdminController::class, 'viewChallenge'])->middleware(['auth:user'])->name('view-challenge');
Route::match(['get', 'post'], '/challenge/new', [AdminController::class, 'addChallenge'])->middleware(['auth:user'])->name('add-challenge');
Route::match(['get', 'post'], '/challenge/{id}/edit', [AdminController::class, 'editChallenge'])->middleware(['auth:user'])->name('edit-challenge');
Route::match(['get', 'post'], '/challenge/{id}/delete', [AdminController::class, 'deleteChallenge'])->middleware(['auth:user'])->name('delete-challenge');

Route::get('/groups', [AdminController::class, 'groups'])->middleware(['auth:user'])->name('groups');
Route::get('/group/{id}', [AdminController::class, 'viewGroup'])->middleware(['auth:user'])->name('view-group');
Route::match(['get', 'post'], '/group/new', [AdminController::class, 'addGroup'])->middleware(['auth:user'])->name('add-group');
Route::match(['get', 'post'], '/group/{id}/edit', [AdminController::class, 'editGroup'])->middleware(['auth:user'])->name('edit-group');
Route::match(['get', 'post'], '/group/{id}/delete', [AdminController::class, 'deleteGroup'])->middleware(['auth:user'])->name('delete-group');
