<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Group;
use App\Models\Team;
use App\Models\Submission;
use App\Events\MessageToTeams;

class TeamController extends Controller {

  public function broadcast(Request $request, $id = false) {
    // without an ID this will broadcast to all teams without differentiating on event -- does this matter? Non-event teams should have been logged out

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

      MessageToTeams::dispatch($request->message, $id); // can we check event_id in this?
      $route = $id ? 'teams' : 'dashboard';
      return redirect()->route($route);
    }
  }

  public function teams() {
    $event = Event::where('active', true)->with('teams')->first();

    return Inertia::render('admin/team/list', [
      'teams' => $event->teams()->orderBy('name')->get()->map(fn($team) => [
        'id' => $team->id,
        'name' => $team->name,
        'group' => $team->group->name,
        'submissions' => $team->submissions()->count()
      ]),
    ]);
  }

  public function viewTeamSubmissions($id) {
    $event = Event::where('active', true)->with(['teams', 'teams.group'])->first();
    $team = $event->teams()->findOrFail($id);
    $submissions = Submission::with(['upload', 'challenge', 'question'])->where('team_id', $id)->orderBy('created_at', 'desc')->paginate(12);

    return Inertia::render('admin/team/submissions', [
      'team' => [
        'name' => $team->name,
        'group' => $team->group->name,
      ],
      'submissions' => $submissions,
    ]);
  }

  public function editTeam(Request $request, $id) {
    if($request->isMethod('get')) {
      $event = Event::where('active', true)->with(['teams', 'groups'])->first();
      $team = $event->teams()->findOrFail($id);
      $groups = $event->groups()->orderBy('number')->orderBy('name')->get();

      return Inertia::render('admin/team/edit', [
        'team' => $team,
        'groups' => $groups,
      ]);
    }
    elseif($request->isMethod('post')) {
      $event = Event::where('active', true)->with('teams')->first();
      $team = $event->teams()->findOrFail($id);

      $data = $request->validate([
        'id' => 'required|exists:teams',
        'name' => ['required', 'string', 'max:255', Rule::unique('teams')->where(fn ($query) => $query->where('event_id', $event->id))->ignore($team->id)],
        'group' => 'required|exists:groups,id',
      ]);

      $team->group()->associate(Group::find($data['group']));
      $team->update($data);
      return redirect()->route('teams');
    }
  }

  public function deleteTeam(Request $request, $id) {
    if($request->isMethod('get')) {
      $team = Event::where('active', true)->with('teams')->first()->teams()->findOrFail($id);

      return Inertia::render('admin/team/delete', [
        'id' => $team->id,
        'name' => $team->name,
      ]);
    }
    elseif($request->isMethod('post')) {
      $team = Event::where('active', true)->with('teams')->first()->teams()->findOrFail($id);
      $team->delete();
      return redirect()->route('teams');
    }
  }

}
