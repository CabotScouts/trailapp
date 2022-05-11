<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Models\Challenge;

class TrailController extends Controller {

  public function index() {
    return Inertia::render('trail', [
      'challenges' => Challenge::all()->map(function($challenge) {
        return [
          'id' => $challege->id,
          'name' => $challenge->name,
          'description' => $challenge->description,
          'points' => $challenge->points,
        ];
      }),
    ]);
  }

  public function viewChallenge() {

  }

  public function challengeSubmission() {

  }

}
