<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use App\Models\Challenge;
use App\Models\Submission;

class ChallengeController extends Controller {

  public function challenges() {
    return Inertia::render('admin/challenge/list', [
      'challenges' => Challenge::with('submissions')->orderBy('name')->get()->map(fn($challenge) => [
        'id' => $challenge->id,
        'name' => $challenge->name,
        'points' => $challenge->points,
        'points_label' => $challenge->pointsLabel,
        'submissions' => $challenge->submissions->count()
      ]),
    ]);
  }

  public function viewChallenge($id) {
    $challenge = Challenge::findOrFail($id);

    return Inertia::render('admin/challenge/view', [
      'challenge' => [
        'id' => $challenge->id,
        'name' => $challenge->name,
        'description' => $challenge->description,
        'points' => $challenge->points,
        'points_label' => $challenge->pointsLabel,
      ],
    ]);
  }

  public function viewChallengeSubmissions($id) {
    $challenge = Challenge::with(['submissions' => function($query) use ($id) {
      $query->where('challenge_id', $id)->orderBy('created_at', 'desc');
    }, 'submissions.team', 'submissions.team.group', 'submissions.upload'])->findOrFail($id);

    return Inertia::render('admin/challenge/submissions', [
      'challenge' => $challenge->name,
      'submissions' => $challenge->submissions->map(fn($submission) => [
        'id' => $submission->id,
        'file' => $submission->file,
        'time' => $submission->time,
        'team' => $submission->team->name,
        'group' => $submission->team->group->name,
        'accepted' => $submission->accepted,
      ]),
    ]);
  }

  public function addChallenge(Request $request) {
    if($request->isMethod('get')) {
      return Inertia::render('admin/challenge/form', [
        'data' => [
          'id' => null,
          'name' => null,
          'description' => null,
          'points' => null,
        ],
      ]);
    }
    elseif($request->isMethod('post')) {
      $data = $request->validate([
        'name' => 'required|string|max:255|unique:challenges',
        'description' => 'required|string|max:255',
        'points' => 'required|numeric|gt:0',
      ]);

      Challenge::insert($data);
      return redirect()->route('challenges');
    }
  }

  public function editChallenge(Request $request, $id) {
    if($request->isMethod('get')) {
      $challenge = Challenge::findOrFail($id);
      return Inertia::render('admin/challenge/form', [
        'data' => [
          'id' => $challenge->id,
          'name' => $challenge->name,
          'description' => $challenge->description,
          'points' => $challenge->points,
        ],
      ]);
    }
    elseif($request->isMethod('post')) {
      $challenge = Challenge::findOrFail($id);

      $data = $request->validate([
        'id' => 'required|exists:challenges',
        'name' => ['required', 'string', 'max:255', Rule::unique('challenges')->ignore($challenge->id)],
        'description' => 'required|string|max:255',
        'points' => 'required|numeric|gt:0',
      ]);

      Challenge::where('id', $challenge->id)->update($data);
      Submission::where('challenge_id', $challenge->id)->where('accepted', 1)->update(['points' => $data['points']]);
      return redirect()->route('challenges');
    }
  }

  public function deleteChallenge(Request $request, $id) {
    if($request->isMethod('get')) {
      $challenge = Challenge::findOrFail($id);
      return Inertia::render('admin/challenge/delete', [
        'id' => $challenge->id,
        'name' => $challenge->name,
      ]);
    }
    elseif($request->isMethod('post')) {
      if($request->id == $id) {
        Challenge::destroy($id);
        return redirect()->route('challenges');
      }
      else {
        return back()->withErrors(['id' => 'The challenge ID is invalid']);
      }
    }
  }
  
}
