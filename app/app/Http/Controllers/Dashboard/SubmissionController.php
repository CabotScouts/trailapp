<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Submission;
use App\Events\SubmissionAccepted;
use App\Events\SubmissionRejected;

class SubmissionController extends Controller {

  public function submissions($filter=false) {
    $event = Event::where('active', true)->first();
    $submissions = Submission::with('upload', 'challenge', 'question', 'team', 'team.group')->where('event_id', $event->id);
    $submissions = ($filter == "pending") ? $submissions->where('accepted', [false, null])->oldest() : $submissions->latest();
    $submissions = $submissions->paginate(12);
    return Inertia::render('admin/submission/list', [ "submissions" => $submissions ]);
  }

  public function acceptSubmission(Request $request) {
    $event = Event::where('active', true)->first();
    $s = Submission::with(['challenge', 'question'])->where('id', $request->id)->where('event_id', $event->id)->firstOrFail();
    $points = ($s->challenge) ? $s->challenge->points : $s->question->points;
    $s->points = $points;
    $s->accepted = true;
    $s->save();

    SubmissionAccepted::dispatch($s);
    return redirect()->back();
  }

  public function rejectSubmission(Request $request, $id) {
    $event = Event::where('active', true)->first();
    $s = Submission::where('id', $request->id)->where('event_id', $event->id)->firstOrFail();
    SubmissionRejected::dispatch($s);
    $s->delete();
    return redirect()->back();
  }

}
