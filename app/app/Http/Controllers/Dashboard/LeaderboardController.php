<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Event;

class LeaderboardController extends Controller {

  public function leaderboard($group=False) {
    $event = Event::with(['groups', 'groups.teams'])->where('active', true)->first();
    $group = ($group) ? $event->groups()->where('id', $group)->firstOrFail() : false;
    $teams = ($group) ? $group->teams : $event->teams;
    
    $teams = $teams->map(fn($team) => [
      'id' => $team->id,
      'name' => $team->name,
      'group' => ($group) ? $group->name : $team->group->name,
      'points' => $team->points,
    ])->sortByDesc('points')->values()->all();

    $groups = $event->groups()->orderBy('number')->orderBy('name')->get()->map(function($group) {
      return [ 'id' => $group->id, 'name' => $group->name ];
    });

    return Inertia::render('admin/leaderboard', [
      'teams' => $teams,
      'groups' => $groups,
      'filter' => ($group) ? $group->id : false,
    ]);
  }

}
