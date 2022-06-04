<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Submission;

class QuestionController extends Controller {

  public function questions() {
    return Inertia::render('admin/question/list', [
      'questions' => Question::orderBy('number')->get()->map(fn($question) => [
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
    $question = Question::findOrFail($id);

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
    $question = Question::findOrFail($id);

    return Inertia::render('admin/question/submissions', [
      'question' => $question->name,
      'submissions' => Submission::where('question_id', $question->id)->orderBy('created_at', 'desc')->get()->map(fn($submission) => [
        'id' => $submission->id,
        'answer' => $submission->answer,
        'time' => $submission->time,
        'team' => $submission->team->name,
        'group' => $submission->team->group->name,
        'accepted' => $submission->accepted,
      ]),
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

      Question::insert($data);
      return redirect()->route('questions');
    }
  }

  public function editQuestion(Request $request, $id) {
    if($request->isMethod('get')) {
      $question = Question::findOrFail($id);
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
      $question = Question::findOrFail($id);

      $data = $request->validate([
        'id' => 'required|exists:questions',
        'number' => 'required|numeric',
        'name' => ['required', 'string', Rule::unique('questions')->ignore($question->id)],
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
      $question = Question::findOrFail($id);
      return Inertia::render('admin/question/delete', [
        'id' => $question->id,
        'name' => $question->name,
      ]);
    }
    elseif($request->isMethod('post')) {
      if($request->id == $id) {
        Question::destroy($id);
        return redirect()->route('questions');
      }
      else {
        return back()->withErrors(['id' => 'The question ID is invalid']);
      }
    }
  }
  
}
