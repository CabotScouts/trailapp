<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\Models\Group;
use App\Models\Team;
use App\Models\Question;
use App\Models\Challenge;
use App\Models\Submission;
use App\Models\User;

use App\Events\SubmissionAccepted;
use App\Events\SubmissionRejected;
use App\Events\MessageToTeams;

class AdminController extends Controller {

  public function login(Request $request) {
    if($request->isMethod('get')) {
      return Inertia::render('admin/login', [
        'name' => config('app.name'),
      ]);
    }
    elseif($request->isMethod('post')) {
      $credentials = $request->validate([
        'username' => 'required|string|max:255',
        'password' => 'required|string',
      ]);

      if(Auth::guard('user')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('dashboard');
      }

      return back()->withErrors(['username' => 'The username or password is incorrect']);
    }
  }

  public function logout(Request $request) {
    Auth::guard('user')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
  }

  public function dashboard() {
    return Inertia::render('admin/dashboard');
  }

  public function broadcast(Request $request) {
    if($request->isMethod('get')) {
      return Inertia::render('admin/broadcast');
    }
    elseif($request->isMethod('post')) {
      $data = $request->validate([
        'message' => 'required'
      ]);
      
      MessageToTeams::dispatch($request->message);
      return redirect()->route('dashboard');
    }
  }

  public function leaderboard() {
    $teams = Team::all()->map(fn($team) => [
      'id' => $team->id,
      'name' => $team->name,
      'group' => $team->group->name,
      'points' => $team->points,
    ])->sortByDesc('points');

    return Inertia::render('admin/leaderboard', [
      'teams' => $teams,
    ]);
  }

  public function submissions($filter=false) {
    $submissions = ($filter == "pending") ? Submission::where('accepted', [false, null])->oldest()->limit(12) : Submission::latest();

    return Inertia::render('admin/submission/list', [
      'submissions' => $submissions->get()->map(fn($submission) => [
        'id' => $submission->id,
        'file' => ($submission->filename) ? url("storage/uploads/{$submission->filename}") : false,
        'answer' => ($submission->answer) ? $submission->answer : false,
        'challenge' => ($submission->challenge) ? $submission->challenge->name : false,
        'question' => ($submission->question) ? ['name' => $submission->question->name, 'text' => $submission->question->question] : false,
        'time' => $submission->time,
        'team' => $submission->team->name,
        'group' => $submission->team->group->name,
        'accepted' => $submission->accepted,
      ]),
    ]);
  }

  public function acceptSubmission(Request $request) {
    $s = Submission::where('id', $request->id)->firstOrFail();
    $points = ($s->challenge) ? $s->challenge->points : $s->question->points;
    $s->points = $points;
    $s->accepted = true;
    $s->save();

    SubmissionAccepted::dispatch($s);
    return redirect()->back();
  }

  public function rejectSubmission(Request $request, $id) {
    $s = Submission::where('id', $request->id)->firstOrFail();
    Storage::delete("public/uploads/{$s->filename}");
    SubmissionRejected::dispatch($s);
    $s->delete();
    return redirect()->back();
  }

  public function teams() {
    return Inertia::render('admin/team/list', [
      'teams' => Team::orderBy('name')->get()->map(fn($team) => [
        'id' => $team->id,
        'name' => $team->name,
        'group' => $team->group->name,
        'submissions' => $team->submissions()->count()
      ]),
    ]);
  }

  public function viewTeamSubmissions($id) {
    $team = Team::findOrFail($id);

    return Inertia::render('admin/team/submissions', [
      'team' => [
        'name' => $team->name,
        'group' => $team->group->name,
      ],
      'submissions' => Submission::where('team_id', $id)->orderBy('created_at', 'desc')->get()->map(fn($submission) => [
        'id' => $submission->id,
        'file' => ($submission->filename) ? url("storage/uploads/{$submission->filename}") : false,
        'answer' => ($submission->answer) ? $submission->answer : false,
        'challenge' => ($submission->challenge) ? $submission->challenge->name : false,
        'question' => ($submission->question) ? ['name' => $submission->question->name, 'text' => $submission->question->question] : false,
        'time' => $submission->time,
        'accepted' => $submission->accepted,
      ]),
    ]);
  }

  public function deleteTeam(Request $request, $id) {
    if($request->isMethod('get')) {
      $team = Team::findOrFail($id);

      return Inertia::render('admin/team/delete', [
        'id' => $team->id,
        'name' => $team->name,
      ]);
    }
    elseif($request->isMethod('post')) {
      if($request->id == $id) {
        Team::destroy($id);
        return redirect()->route('teams');
      }
      else {
        return back()->withErrors(['id' => 'The team ID is invalid']);
      }
    }
  }

  public function questions() {
    return Inertia::render('admin/question/list', [
      'questions' => Question::orderBy('number')->get()->map(fn($question) => [
        'id' => $question->id,
        'number' => $question->number,
        'name' => $question->name,
        'points' => $question->points,
        'submissions' => $question->submissions->count()
      ]),
    ]);
  }

  public function viewQuestion($id) {
    $question = Question::findOrFail($id);

    return Inertia::render('admin/question/view', [
      'question' => $question
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
        'points' => 'required|numeric',
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
        'points' => 'required|numeric',
      ]);

      Question::where('id', $question->id)->update($data);
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

  public function challenges() {
    return Inertia::render('admin/challenge/list', [
      'challenges' => Challenge::orderBy('points', 'desc')->orderBy('name')->get()->map(fn($challenge) => [
        'id' => $challenge->id,
        'name' => $challenge->name,
        'points' => $challenge->points,
        'submissions' => $challenge->submissions->count()
      ]),
    ]);
  }

  public function viewChallenge($id) {
    $challenge = Challenge::findOrFail($id);

    return Inertia::render('admin/challenge/view', [
      'challenge' => $challenge
    ]);
  }

  public function viewChallengeSubmissions($id) {
    $challenge = Challenge::findOrFail($id);

    return Inertia::render('admin/challenge/submissions', [
      'challenge' => $challenge->name,
      'submissions' => Submission::where('challenge_id', $id)->orderBy('created_at', 'desc')->get()->map(fn($submission) => [
        'id' => $submission->id,
        'file' => url("storage/uploads/{$submission->filename}"),
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
        'points' => 'required|numeric',
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
        'points' => 'required|numeric',
      ]);

      Challenge::where('id', $request->id)->update($data);
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

  public function groups() {
    return Inertia::render('admin/group/list', [
      'groups' => Group::orderBy('number')->orderBy('name')->get()->map(fn($group) => [
        'id' => $group->id,
        'name' => $group->name,
        'teams' => $group->teams()->count()
      ]),
    ]);
  }

  public function viewGroupTeams($id) {
    $group = Group::findOrFail($id);

    return Inertia::render('admin/group/teams', [
      'group' => $group->name,
      'teams' => Team::where('group_id', $id)->orderBy('name')->get()->map(fn($team) => [
        'id' => $team->id,
        'name' => $team->name,
        'group' => $team->group->name,
        'submissions' => $team->submissions()->count()
      ]),
    ]);
  }

  public function addGroup(Request $request) {
    if($request->isMethod('get')) {
      return Inertia::render('admin/group/form', [
        'data' => [ 'name' => null, 'number' => null ],
      ]);
    }
    elseif($request->isMethod('post')) {
      $data = $request->validate([
        'name' => 'required|string|max:255|unique:groups',
        'number' => 'required|numeric',
      ]);

      Group::insert($data);
      return redirect()->route('groups');
    }
  }

  public function editGroup(Request $request, $id) {
    if($request->isMethod('get')) {
      $group = Group::findOrFail($id);
      return Inertia::render('admin/group/form', [
        'data' => [
          'id' => $group->id,
          'name' => $group->name,
          'number' => $group->number ],
      ]);
    }
    elseif($request->isMethod('post')) {
      $group = Group::findOrFail($id);

      $data = $request->validate([
        'id' => 'required|exists:groups',
        'name' => ['required', 'string', 'max:255', Rule::unique('groups')->ignore($group->id)],
        'number' => 'required|numeric',
      ]);

      Group::where('id', $request->id)->update($data);
      return redirect()->route('groups');
    }
  }

  public function deleteGroup(Request $request, $id) {
    if($request->isMethod('get')) {
      $group = Group::findOrFail($id);
      return Inertia::render('admin/group/delete', [
        'id' => $group->id,
        'name' => $group->name,
      ]);
    }
    elseif($request->isMethod('post')) {
      if($request->id == $id) {
        Group::destroy($id);
        return redirect()->route('groups');
      }
      else {
        return back()->withErrors(['id' => 'The group ID is invalid']);
      }
    }
  }
  
  public function users() {
    $users = User::where('id', '!=', 1)->get();
    return Inertia::render('admin/user/list', [
      'users' => $users->map(fn($user) => [
        'id' => $user->id,
        'username' => $user->username,
      ])
    ]);
  }
  
  public function addUser(Request $request) {
    if($request->isMethod('get')) {
      return Inertia::render('admin/user/form', [
        'data' => [ 'id' => null, 'username' => null ],
      ]);
    }
    elseif($request->isMethod('post')) {
      $data = $request->validate([
        'username' => 'required|string|max:255|unique:users',
        'password' => 'required|min:8|same:password_confirmation',
        'password_confirmation' => 'required',
      ]);

      User::create([
        'username' => $data['username'],
        'password' => Hash::make($data['password']),
      ]);
      return redirect()->route('users');
    }
  }
  
  public function editUser(Request $request, $id) {
    $user = User::findOrFail($id);
    
    if($request->isMethod('get')) {
      return Inertia::render('admin/user/form', [
        'data' => [ 
          'id' => $user->id,
          'username' => $user->username,
          'canDelete' => ($user->id !== Auth::user()->id),
        ],
      ]);
    }
    elseif($request->isMethod('post')) {
      if($id != 1) {
        $data = $request->validate([
          'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
          'password' => 'required|min:8|same:password_confirmation',
          'password_confirmation' => 'required',
        ]);

        $user->update([
          'username' => $data['username'],
          'password' => Hash::make($data['password']),
        ]);
        return redirect()->route('users');
      }
      else {
        return back()->withErrors(['id' => 'The user ID is invalid']);
      }
    }
  }
  
  public function deleteUser(Request $request, $id) {
    if($request->isMethod('get')) {
      $user = User::findOrFail($id);
      
      return Inertia::render('admin/user/delete', [
        'id' => $user->id,
        'username' => $user->username,
        'canDelete' => ($user->id !== Auth::user()->id),
      ]);
    }
    elseif($request->isMethod('post')) {
      if($request->id == $id && $id !== 1) {
        if($request->id !== Auth::user()->id) {
          User::destroy($id);
          return redirect()->route('users');
        }
        else {
          return back()->withErrors(['id' => 'You cannot delete yourself!']);
        }
      }
      else {
        return back()->withErrors(['id' => 'The user ID is invalid']);
      }
    }
  }

}
