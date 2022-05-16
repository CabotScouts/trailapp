<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\Challenge;
use App\Models\Submission;

class TrailController extends Controller {

  public function index() {
    return Inertia::render('challenge-list', [
      'challenges' => Challenge::orderBy('points', 'desc')
        ->orderBy('name')
        ->get()
        ->map(function($challenge) {
          return [
            'id' => $challenge->id,
            'name' => $challenge->name,
            'points' => $challenge->points,
            'submitted' => (Auth::user()->submissions()->where('challenge_id', $challenge->id)->count() > 0),
          ];
        }),
      'team' => Auth::user()->name,
      'group' => Auth::user()->group->name,
    ]);
  }

  public function viewChallenge($id) {
    $challenge = Challenge::findOrFail($id);
    $submission = Auth::user()->submissions()->where('challenge_id', $challenge->id)->first();

    return Inertia::render('challenge-view', [
      'challenge' => $challenge,
      'submission' => $submission ? url("storage/uploads/{$submission->filename}") : false,
    ]);
  }

  public function challengeSubmission(Request $request, $id) {
    Validator::make($request->all(),
      [
        'photo' => 'required|image',
      ],
      [
        'photo.required' => 'You need to select a photo to upload',
        'photo.image' => 'You need to select a photo to upload',
      ]
    )->validate();

    $ext = $request->photo->extension();
    $filename = strval(Auth::user()->id) . "_" . $id . "_" . Str::random(15) . "." . $ext;
    $request->photo->storeAs("public/uploads/", $filename);

    $submission = Submission::firstOrNew(
      [
        'challenge_id' => $id,
        'team_id' => Auth::user()->id,
      ]
    );

    $submission->filename = $filename;
    $submission->save();

    return redirect()->route('challenge', $id);
  }

}
