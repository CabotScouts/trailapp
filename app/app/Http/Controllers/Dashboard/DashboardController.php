<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Team;

class DashboardController extends Controller {

  public function dashboard() {
    return Inertia::render('admin/dashboard');
  }

  public function leaderboard() {
    $teams = Team::all()->map(fn($team) => [
      'id' => $team->id,
      'name' => $team->name,
      'group' => $team->group->name,
      'points' => $team->points,
    ])->sortByDesc('points')->values()->all();

    return Inertia::render('admin/leaderboard', [
      'teams' => $teams,
    ]);
  }

}
