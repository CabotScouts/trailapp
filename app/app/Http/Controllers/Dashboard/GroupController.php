<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use App\Models\Group;

class GroupController extends Controller {

  public function groups() {
    return Inertia::render('admin/group/list', [
      'groups' => Group::with('teams')->orderBy('number')->orderBy('name')->get()->map(fn($group) => [
        'id' => $group->id,
        'name' => $group->name,
        'teams' => $group->teams()->count()
      ]),
    ]);
  }

  public function viewGroupTeams($id) {
    $group = Group::with(['teams' => function($query) use ($id) {
      $query->where('group_id', $id)->orderBy('name');
    }, 'teams.submissions'])->findOrFail($id);

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
      $data = $request->validate([
        'name' => 'required|string|max:255|unique:groups',
        'number' => 'required|numeric',
      ]);

      Group::insert($data);
      return redirect()->route('groups');
    }
  }

  public function editGroup(Request $request, $id) {
    if($request->isMethod('get')) {
      $group = Group::findOrFail($id);
      return Inertia::render('admin/group/form', [
        'data' => [
          'id' => $group->id,
          'name' => $group->name,
          'number' => $group->number ],
      ]);
    }
    elseif($request->isMethod('post')) {
      $group = Group::findOrFail($id);

      $data = $request->validate([
        'id' => 'required|exists:groups',
        'name' => ['required', 'string', 'max:255', Rule::unique('groups')->ignore($group->id)],
        'number' => 'required|numeric',
      ]);

      Group::where('id', $group->id)->update($data);
      return redirect()->route('groups');
    }
  }

  public function deleteGroup(Request $request, $id) {
    if($request->isMethod('get')) {
      $group = Group::findOrFail($id);
      return Inertia::render('admin/group/delete', [
        'id' => $group->id,
        'name' => $group->name,
      ]);
    }
    elseif($request->isMethod('post')) {
      if($request->id == $id) {
        Group::destroy($id);
        return redirect()->route('groups');
      }
      else {
        return back()->withErrors(['id' => 'The group ID is invalid']);
      }
    }
  }
  
}
