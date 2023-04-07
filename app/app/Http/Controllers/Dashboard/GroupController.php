<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Group;

class GroupController extends Controller {

  public function groups() {
    $event = Event::where('active', true)->with(['groups', 'groups.teams'])->first();

    return Inertia::render('admin/group/list', [
      'groups' => $event->groups()->orderBy('number')->orderBy('name')->get()->map(fn($group) => [
        'id' => $group->id,
        'name' => $group->name,
        'teams' => $group->teams()->count()
      ]),
    ]);
  }

  public function viewGroupTeams($id) {
    $event = Event::where('active', true)->with(['groups.teams' => function($query) use ($id) {
      $query->where('group_id', $id)->orderBy('name');
    }, 'groups.teams.submissions'])->first();

    $group = $event->groups()->findOrFail($id);

    return Inertia::render('admin/group/teams', [
      'group' => $group->name,
      'teams' => $group->teams->map(fn($team) => [
        'id' => $team->id,
        'name' => $team->name,
        'group' => $team->group->name,
        'submissions' => $team->submissions()->count()
      ]),
    ]);
  }

  public function addGroup(Request $request) {
    if($request->isMethod('get')) {
      return Inertia::render('admin/group/form', [
        'data' => [ 'name' => null, 'number' => null ],
      ]);
    }
    elseif($request->isMethod('post')) {
      $event = Event::where('active', true)->first();

      $data = $request->validate([
        'name' => ['required', 'string', 'max:255', Rule::unique('groups')->where(fn ($query) => $query->where('event_id', $event->id))],
        'number' => 'required|numeric',
      ]);

      $group = Group::create($data);
      $event->groups()->save($group);
      return redirect()->route('groups');
    }
  }

  public function editGroup(Request $request, $id) {
    if($request->isMethod('get')) {
      $group = Event::where('active', true)->with('groups')->first()->groups()->findOrFail($id);

      return Inertia::render('admin/group/form', [
        'data' => [
          'id' => $group->id,
          'name' => $group->name,
          'number' => $group->number ],
      ]);
    }
    elseif($request->isMethod('post')) {
      $event = Event::where('active', true)->with('groups')->first();
      $group= $event->groups()->findOrFail($id);

      $data = $request->validate([
        'id' => 'required|exists:groups',
        'name' => ['required', 'string', 'max:255', Rule::unique('groups')->where(fn ($query) => $query->where('event_id', $event->id))->ignore($group->id)],
        'number' => 'required|numeric',
      ]);

      $group->update($data);
      return redirect()->route('groups');
    }
  }

  public function deleteGroup(Request $request, $id) {
    if($request->isMethod('get')) {
      $group = Event::where('active', true)->with('groups')->first()->groups()->findOrFail($id);

      return Inertia::render('admin/group/delete', [
        'id' => $group->id,
        'name' => $group->name,
      ]);
    }
    elseif($request->isMethod('post')) {
      $group = Event::where('active', true)->with('groups')->first()->groups()->findOrFail($id);
      $groups->delete();
      return redirect()->route('groups');
    }
  }
  
}
