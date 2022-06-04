<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Events\MessageToTeams;

class DashboardController extends Controller {

  public function dashboard() {
    return Inertia::render('admin/dashboard');
  }

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
      if($id) {
        return redirect()->route('teams');
      }
      else {
        return redirect()->route('dashboard');
      }
    }
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
