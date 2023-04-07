<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Question;
use App\Models\Submission;

class QuestionController extends Controller {

  public function questions() {
    $event = Event::where('active', true)->with(['questions', 'questions.submissions'])->first();

    return Inertia::render('admin/question/list', [
      'questions' => $event->questions()->orderBy('number')->get()->map(fn($question) => [
        'id' => $question->id,
        'number' => $question->number,
        'name' => $question->name,
        'points' => $question->points,
        'points_label' => $question->pointsLabel,
        'submissions' => $question->submissions->count()
      ]),
    ]);
  }

  public function viewQuestion($id) {
    $event = Event::where('active', true)->with('questions')->first();
    $question = $event->questions()->findOrFail($id);

    return Inertia::render('admin/question/view', [
      'question' => [
        'id' => $question->id,
        'number' => $question->number,
        'name' => $question->name,
        'question' => $question->question,
        'points' => $question->points,
        'points_label' => $question->pointsLabel,
      ],
    ]);
  }

  public function viewQuestionSubmissions($id) {
    // TODO: filter submissions to only fetch for question ID
    $event = Event::where('active', true)->with(['questions', 'questions.submissions'])->first();
    $question = $event->questions()->findOrFail($id);
    $submissions = $question->submissions()->orderBy('created_at', 'desc')->paginate(12);

    return Inertia::render('admin/question/submissions', [
      'question' => $question->name,
      'submissions' => $submissions,
    ]);
  }

  public function addQuestion(Request $request) {
    if($request->isMethod('get')) {
      return Inertia::render('admin/question/form', [
        'data' => [
          'id' => null,
          'number' => null,
          'name' => null,
          'question' => null,
          'points' => null,
        ],
      ]);
    }
    elseif($request->isMethod('post')) {
      $data = $request->validate([
        'name' => 'required|string|max:255|unique:questions',
        'number' => 'required|numeric',
        'question' => 'required|string',
        'points' => 'required|numeric|gt:0',
      ]);

      $question = Question::create($data);
      Event::where('active', true)->first()->questions()->save($question);
      return redirect()->route('questions');
    }
  }

  public function editQuestion(Request $request, $id) {
    if($request->isMethod('get')) {
      $event = Event::where('active', true)->with('questions')->first();
      $question = $event->questions()->findOrFail($id);
      return Inertia::render('admin/question/form', [
        'data' => [
          'id' => $question->id,
          'number' => $question->number,
          'name' => $question->name,
          'question' => $question->question,
          'points' => $question->points,
        ],
      ]);
    }
    elseif($request->isMethod('post')) {
      $event = Event::where('active', true)->with('questions')->first();
      $question = $event->questions()->findOrFail($id);

      $data = $request->validate([
        'id' => 'required|exists:questions',
        'number' => 'required|numeric',
        'name' => 'required|string',
        'question' => 'required|string',
        'points' => 'required|numeric|gt:0',
      ]);

      Question::where('id', $question->id)->update($data);
      Submission::where('question_id', $question->id)->where('accepted', 1)->update(['points' => $data['points']]);
      return redirect()->route('questions');
    }
  }

  public function deleteQuestion(Request $request, $id) {
    if($request->isMethod('get')) {
      $event = Event::where('active', true)->with('questions')->first();
      $question = $event->questions()->findOrFail($id);
      return Inertia::render('admin/question/delete', [
        'id' => $question->id,
        'name' => $question->name,
      ]);
    }
    elseif($request->isMethod('post')) {
      $event = Event::where('active', true)->with('questions')->first();
      $question = $event->questions()->findOrFail($id);
      $question->delete();
      return redirect()->route('questions');
    }
  }
  
}
