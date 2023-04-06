<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

use App\Models\Event;
use App\Models\Team;

class TeamController extends Controller {

  public function index(Request $request) {
    $event = Event::with('groups')->where('active', true)->first();

    return Inertia::render('create-team', [
      'name' => $event->name,
      'running' => $event->running,
      'groups' => $event->groups()->orderBy('number')->orderBy('name')->get()->map(function($group) {
        return [ 'id' => $group->id, 'name' => $group->name ];
      }),
    ]);
  }

  public function create(Request $request) {
    Validator::make(
      $request->all(),
      [
        'group' => 'required|exists:groups,id',
        'name' => ['required', 'string', 'max:255', Rule::unique('teams')->where(fn ($query) => $query->where('group_id', $request->group))],
      ],
      [
        'group.required' => 'You need to choose your group',
        'group.exists' => 'The group you\'ve chosen doesn\'t exist',
        'name.required' => 'You need to enter a team name',
        'name.unique' => 'Someone in your group is already using this team name',
      ],
    )->validate();

    $team = Team::create([
      'group_id' => $request->group,
      'name' => $request->name,
      'join_token' => Str::random(100),
    ]);

    $team->generateQR();

    Auth::guard('team')->login($team, true);
    return redirect()->route('trail');
  }

  public function join($id, $code) {
    $team = Team::where('id', $id)->firstOrFail();
    
    if($team->join_token == $code) {
      Auth::guard('team')->loginUsingId($id, true);
      return redirect()->route('trail');
    }
    
    return redirect()->route('start');
  }

  public function clone(Request $request, $id) {
    Auth::guard('team')->loginUsingId($id, true);
    return redirect()->route('trail');
  }

  public function destroy(Request $request) {
    Auth::guard('team')->logout();
    return redirect()->route('start');
  }

}
