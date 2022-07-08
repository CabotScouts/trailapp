<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Events\SubmissionAccepted;
use App\Events\SubmissionRejected;

class SubmissionController extends Controller {

  public function submissions($filter=false) {
    $submissions = Submission::with('upload', 'challenge', 'question', 'team', 'team.group');
    $submissions = ($filter == "pending") ? $submissions->where('accepted', [false, null])->oldest() : $submissions->latest();
    $submissions = $submissions->paginate(10);
    return Inertia::render('admin/submission/list', $submissions);
  }

  public function acceptSubmission(Request $request) {
    $s = Submission::with(['challenge', 'question'])->where('id', $request->id)->firstOrFail();
    $points = ($s->challenge) ? $s->challenge->points : $s->question->points;
    $s->points = $points;
    $s->accepted = true;
    $s->save();

    SubmissionAccepted::dispatch($s);
    return redirect()->back();
  }

  public function rejectSubmission(Request $request, $id) {
    $s = Submission::where('id', $request->id)->firstOrFail();
    SubmissionRejected::dispatch($s);
    $s->delete();
    return redirect()->back();
  }

}
