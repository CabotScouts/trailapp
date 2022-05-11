<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Challenge;

class TrailController extends Controller {

  public function index() {
    return Inertia::render('trail', [
      'challenges' => Challenge::all()->map(function($challenge) {
        return [
          'id' => $challenge->id,
          'name' => $challenge->name,
          'description' => $challenge->description,
          'points' => $challenge->points,
        ];
      }),
      'team' => Auth::user()->name,
    ]);
  }

  public function viewChallenge() {

  }

  public function challengeSubmission() {

  }

}
