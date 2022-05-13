<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

use App\Models\Group;
use App\Models\Team;

class TeamController extends Controller {

  public function index(Request $request) {
    return Inertia::render('create-team', [
      'name' => config('app.name'),
      'groups' => Group::orderBy('number')->orderBy('name')->get()->map(function($group) {
        return [ 'id' => $group->id, 'name' => $group->name ];
      }),
    ]);
  }

  public function create(Request $request) {
    Validator::make(
      $request->all(),
      [
        'group' => 'required|exists:groups,id',
        'name' => ['required', 'string', Rule::unique('teams')->where(fn ($query) => $query->where('group_id', $request->group))],
      ],
      [
        'group.required' => 'You need to choose your Scout Group',
        'group.exists' => 'The Scout Group you\'ve chosen doesn\'t exist',
        'name.required' => 'You need to enter a team name',
        'name.unique' => 'Someone in your Scout Group is already using this team name',
      ],
    )->validate();

    $team = Team::create([
      'group_id' => $request->group,
      'name' => $request->name,
    ]);

    Auth::guard('team')->login($team, true);
    $request->session()->regenerate();

    return redirect()->route('trail');
  }

  public function clone(Request $request, $id) {
    if(!App::environment('production')) {
      Auth::guard('team')->loginUsingId($id, true);
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return redirect()->route('trail');
    }

    return redirect()->route('start');
  }

  public function destroy(Request $request) {
    if(!App::environment('production')) {
      Auth::guard('team')->logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
    }

    return redirect()->route('start');
  }

}
