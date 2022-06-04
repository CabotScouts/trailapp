<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Submission;
use App\Events\MessageToTeams;

class TeamController extends Controller {

  public function broadcast(Request $request, $id = false) {
    $team = ($id) ? Team::where('id', $id)->firstOrFail() : false;
    
    if($request->isMethod('get')) {
      return Inertia::render('admin/broadcast', [
        'id' => ($team) ? $team->id : null,
        'name' => ($team) ? $team->name : null,
      ]);
    }
    elseif($request->isMethod('post')) {
      $data = $request->validate([
        'message' => 'required'
      ]);
      
      MessageToTeams::dispatch($request->message, $id);
      $route = $id ? 'teams' : 'dashboard';
      return redirect()->route($route);
    }
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
        'file' => $submission->file,
        'answer' => ($submission->answer) ? $submission->answer : false,
        'challenge' => ($submission->challenge) ? $submission->challenge->name : false,
        'question' => ($submission->question) ? ['name' => $submission->question->name, 'text' => $submission->question->question] : false,
        'time' => $submission->time,
        'accepted' => $submission->accepted,
      ]),
    ]);
  }

  public function deleteTeam(Request $request, $id) {
    if($request->isMethod('get')) {
      $team = Team::findOrFail($id);

      return Inertia::render('admin/team/delete', [
        'id' => $team->id,
        'name' => $team->name,
      ]);
    }
    elseif($request->isMethod('post')) {
      if($request->id == $id) {
        Team::destroy($id);
        return redirect()->route('teams');
      }
      else {
        return back()->withErrors(['id' => 'The team ID is invalid']);
      }
    }
  }
  
}
