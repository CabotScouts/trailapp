<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Team;

class LeaderboardController extends Controller {

  public function leaderboard($group=False) {
    $group = ($group) ? Group::where('id', $group)->firstOrFail() : false;
    $teams = ($group) ? $group->teams : Team::with('group')->get();
    
    $teams = $teams->map(fn($team) => [
      'id' => $team->id,
      'name' => $team->name,
      'group' => ($group) ? $group->name : $team->group->name,
      'points' => $team->points,
    ])->sortByDesc('points')->values()->all();

    $groups = Group::orderBy('number')->orderBy('name')->get()->map(function($group) {
      return [ 'id' => $group->id, 'name' => $group->name ];
    });

    return Inertia::render('admin/leaderboard', [
      'teams' => $teams,
      'groups' => $groups,
      'filter' => ($group) ? $group->id : false,
    ]);
  }

}
