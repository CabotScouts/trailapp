<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

use App\Models\Question;
use App\Models\Challenge;
use App\Models\Submission;

class TrailController extends Controller {

  public function questions() {
    return Inertia::render('question/list', [
      'team' => Auth::user()->name,
      'group' => Auth::user()->group->name,
      'points' => Auth::user()->points,
      'questions' => Question::orderBy('points', 'desc')->get()
        ->map(function($question) {
          $submissions = Auth::user()->submissions()->where('question_id', $question->id);
          return [
            'id' => $question->id,
            'number' => $question->number,
            'name' => $question->name,
            'points' => $question->points,
            'submitted' => ($submissions->count() > 0),
            'accepted' => ($submissions->where('accepted', true)->count() > 0),
          ];
        }),
    ]);
  }

  public function viewQuestion($id) {
    $question = Question::findOrFail($id);
    $submission = Auth::user()->submissions()->where('question_id', $question->id)->first();

    return Inertia::render('question/view', [
      'question' => $question,
      'submission' => $submission ? [ 'answer' => $submission->answer, 'accepted' => $submission->accepted ] : [ 'answer' => false, 'accepted' => false ],
    ]);
  }

  public function questionSubmission(Request $request, $id) {
    Validator::make($request->all(),
      [
        'answer' => 'required|string',
      ],
      [
        'answer.required' => 'You need to give your answer',
      ]
    )->validate();

    $submission = Submission::firstOrNew(
      [
        'question_id' => $id,
        'team_id' => Auth::user()->id,
      ]
    );
    $submission->answer = $request->answer;
    $submission->save();

    return redirect()->route('trail');
  }

  public function challenges() {
    return Inertia::render('challenge/list', [
      'team' => Auth::user()->name,
      'group' => Auth::user()->group->name,
      'points' => Auth::user()->points,
      'challenges' => Challenge::orderBy('points', 'desc')
        ->orderBy('name')
        ->get()
        ->map(function($challenge) {
          $submissions = Auth::user()->submissions()->where('challenge_id', $challenge->id);
          return [
            'id' => $challenge->id,
            'name' => $challenge->name,
            'points' => $challenge->points,
            'submitted' => ($submissions->count() > 0),
            'accepted' => ($submissions->where('accepted', true)->count() > 0),
          ];
        }),
    ]);
  }

  public function viewChallenge($id) {
    $challenge = Challenge::findOrFail($id);
    $submission = Auth::user()->submissions()->where('challenge_id', $challenge->id)->first();

    return Inertia::render('challenge/view', [
      'challenge' => $challenge,
      'submission' => $submission ? [ 'file' => url("storage/uploads/{$submission->filename}"), 'accepted' => $submission->accepted ] : [ 'file' => false, 'accepted' => false ],
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

  public function showQR() {
    return Inertia::render('join-team', [
      'team' => Auth::user()->name,
      'src' => route('qr-image'),
    ]);
  }
  
  public function getQRImage() {
    $id = Auth::user()->id;
    $qr = storage_path("app/qr/{$id}.png");
    return response()->file($qr);
  }

}
