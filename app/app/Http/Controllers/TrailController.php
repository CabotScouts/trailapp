<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

use App\Helpers;
use App\Models\Event;
use App\Models\Submission;
use App\Models\Upload;
use App\Jobs\ProcessUpload;
use App\Events\SubmissionReceived;

class TrailController extends Controller {

  public function questions() {
    $user = Auth::user();
    $event = Event::where('active', true)->with(['questions', 'questions.submissions' => function($query) use ($user) { $query->where('team_id', $user->id); }])->first();
    
    return Inertia::render('question/list', [
      'team' => ['id' => $user->id, 'name' => $user->name],
      'group' => $user->group->name,
      'points' => Helpers::points($user->points),
      'questions' => $event->questions()->orderBy('number')->get()
        ->map(function($question) {
          return [
            'id' => $question->id,
            'number' => $question->number,
            'name' => $question->name,
            'points' => $question->pointsLabel,
            'submitted' => ($question->submissions->count() > 0),
            'accepted' => ($question->submissions->where('accepted', true)->count() > 0),
          ];
        }),
    ]);
  }

  public function viewQuestion($id) {
    $event = Event::where('active', true)->with(['questions', 'questions.submissions' => function($query) { $query->where('team_id', Auth::user()->id); }])->first();
    $question = $event->questions()->findOrFail($id);
    $submission = $question->submissions->first();

    return Inertia::render('question/view', [
      'question' => [
        'id' => $question->id,
        'number' => $question->number,
        'name' => $question->name,
        'question' => $question->question,
        'points' => $question->points,
        'points_label' => $question->pointsLabel,
      ],
      'submission' => $submission ? [ 'answer' => $submission->answer, 'accepted' => $submission->accepted ] : [ 'answer' => false, 'accepted' => false ],
    ]);
  }

  public function questionSubmission(Request $request, $id) {
    $event = Event::where('active', true)->first();

    Validator::make($request->all(),
      [
        'question' => ['required', Rule::exists('questions', 'id')->where(fn ($query) => $query->where('event_id', $event->id))],
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
    
    SubmissionReceived::dispatch($submission);
    return redirect()->route('trail');
  }

  public function challenges() {
    $user = Auth::user();
    $event = Event::where('active', true)->with(['challenges', 'challenges.submissions' => function($query) use ($user) { $query->where('team_id', $user->id); }])->first();
    
    return Inertia::render('challenge/list', [
      'team' => ['id' => $user->id, 'name' => $user->name],
      'group' => $user->group->name,
      'points' => Helpers::points($user->points),
      'challenges' => $event->challenges()->orderBy('points', 'desc')
        ->orderBy('name')
        ->get()
        ->map(function($challenge) {
          return [
            'id' => $challenge->id,
            'name' => $challenge->name,
            'points' => $challenge->pointsLabel,
            'submitted' => ($challenge->submissions->count() > 0),
            'accepted' => ($challenge->submissions->where('accepted', true)->count() > 0),
          ];
        }),
    ]);
  }

  public function viewChallenge($id) {
    $event = Event::where('active', true)->with(['challenges', 'challenges.submissions' => function($query) { $query->where('team_id', Auth::user()->id); }])->first();
    $challenge = $event->challenges()->findOrFail($id);
    $submission = $challenge->submissions->first();

    return Inertia::render('challenge/view', [
      'challenge' => [
        'id' => $challenge->id,
        'name' => $challenge->name,
        'description' => $challenge->description,
        'points' => $challenge->points,
        'points_label' => $challenge->pointsLabel,
      ],
      'submission' => $submission ? [ 'upload' => ($submission->upload) ? [ 
        'file' => $submission->upload->file, 
        'link' => $submission->upload->link ] : false, 
        'accepted' => $submission->accepted ] : [ 'upload' => false, 'accepted' => false ],
    ]);
  }

  public function challengeSubmission(Request $request, $id) {
    $event = Event::where('active', true)->first();

    Validator::make($request->all(),
      [
        'challenge' => ['required', Rule::exists('questions', 'id')->where(fn ($query) => $query->where('event_id', $event->id))],
        'photo' => 'required|image|max:12000',
      ],
      [
        'photo.required' => 'You need to select a photo to upload',
        'photo.image' => 'You need to select a photo to upload',
        'photo.max' => 'The photo you tried to upload is too big (maximum size is 12MB)',
      ]
    )->validate();

    Submission::where('challenge_id', $id)->where('team_id', Auth::user()->id)->delete();
    
    $upload = Upload::fromFile($request->photo, $id);
    $submission = Submission::create(
      [
        'challenge_id' => $id,
        'team_id' => Auth::user()->id,
        'upload_id' => $upload->id,
      ]
    );
    $upload->submission()->associate($submission);
    $upload->save();

    ProcessUpload::dispatch($upload);
    SubmissionReceived::dispatch($submission);
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
