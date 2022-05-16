<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\Group;
use App\Models\Team;
use App\Models\Challenge;
use App\Models\Submission;

class AdminController extends Controller {

  public function login(Request $request) {
    if($request->isMethod('get')) {
      return Inertia::render('admin/login', [
        'name' => config('app.name'),
      ]);
    }
    elseif($request->isMethod('post')) {
      $credentials = $request->validate([
        'username' => 'required|string|max:255',
        'password' => 'required|string',
      ]);

      if(Auth::guard('user')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('dashboard');
      }

      return back()->withErrors(['username' => 'The username or password is incorrect']);
    }
  }

  public function logout(Request $request) {
    Auth::guard('user')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
  }

  public function dashboard(Request $request) {
    return Inertia::render('admin/dashboard');
  }

  public function submissions() {
    return Inertia::render('admin/submission/list', [
      'submissions' => Submission::orderBy('created_at', 'desc')->get()->map(fn($submission) => [
        'id' => $submission->id,
        'file' => url("storage/uploads/{$submission->filename}"),
        'challenge' => $submission->challenge->name,
        'time' => $submission->time,
        'team' => $submission->team->name,
        'group' => $submission->team->group->name,
      ]),
    ]);
  }

  public function acceptSubmission($id) {
    
  }

  public function deleteSubmission($id) {

  }

  public function teams() {
    return Inertia::render('admin/team/list', [
      'teams' => Team::orderBy('name')->get()->map(fn($team) => [
        'id' => $team->id,
        'name' => $team->name,
        'group' => $team->group->name,
        'submissions' => $team->submissions()->count()
      ]),
    ]);
  }

  public function viewTeamSubmissions($id) {
    $team = Team::findOrFail($id);

    return Inertia::render('admin/team/submissions', [
      'team' => [
        'name' => $team->name,
        'group' => $team->group->name,
      ],
      'submissions' => Submission::where('team_id', $id)->orderBy('created_at', 'desc')->get()->map(fn($submission) => [
        'id' => $submission->id,
        'file' => url("storage/uploads/{$submission->filename}"),
        'challenge' => $submission->challenge->name,
        'time' => $submission->time,
      ]),
    ]);
  }

  public function deleteTeam() {

  }

  public function challenges() {
    return Inertia::render('admin/challenge/list', [
      'challenges' => Challenge::orderBy('points', 'desc')->orderBy('name')->get()->map(fn($challenge) => [
        'id' => $challenge->id,
        'name' => $challenge->name,
        'description' => Str::limit($challenge->description, 30),
        'points' => $challenge->points
      ]),
    ]);
  }

  public function viewChallenge() {

  }

  public function viewChallengeSubmissions($id) {
    $challenge = Challenge::findOrFail($id);

    return Inertia::render('admin/challenge/submissions', [
      'challenge' => $challenge->name,
      'submissions' => Submission::where('challenge_id', $id)->orderBy('created_at', 'desc')->get()->map(fn($submission) => [
        'id' => $submission->id,
        'file' => url("storage/uploads/{$submission->filename}"),
        'challenge' => $submission->challenge->name,
        'time' => $submission->time,
      ]),
    ]);
  }

  public function addChallenge() {

  }

  public function editChallenge() {

  }

  public function deleteChallenge() {

  }

  public function groups() {
    return Inertia::render('admin/group/list', [
      'groups' => Group::orderBy('number')->orderBy('name')->get()->map(fn($group) => [
        'id' => $group->id,
        'name' => $group->name,
        'teams' => $group->teams()->count()
      ]),
    ]);
  }

  public function viewGroupTeams($id) {
    $group = Group::findOrFail($id);

    return Inertia::render('admin/group/teams', [
      'group' => $group->name,
      'teams' => Team::where('group_id', $id)->orderBy('name')->get()->map(fn($team) => [
        'id' => $team->id,
        'name' => $team->name,
        'group' => $team->group->name,
        'submissions' => $team->submissions()->count()
      ]),
    ]);
  }

  public function addGroup() {

  }

  public function editGroup($id) {

  }

  public function deleteGroup($id) {

  }

}
