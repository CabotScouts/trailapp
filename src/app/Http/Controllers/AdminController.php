<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;

use App\Models\Team;

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
    else {
      // how?
      return redirect()->route('login');
    }
  }

  public function logout(Request $request) {
    Auth::guard('user')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
  }

  public function dashboard(Request $request) {
    return Inertia::render('admin/dashboard');
  }

  public function submissions() {

  }

  public function viewSubmission() {

  }

  public function acceptSubmission() {

  }

  public function deleteSubmission() {

  }

  public function teams() {

  }

  public function viewTeam() {

  }

  public function deleteTeam() {

  }

  public function challenges() {

  }

  public function viewChallenge() {

  }

  public function addChallenge() {

  }

  public function editChallenge() {

  }

  public function deleteChallenge() {

  }

  public function groups() {

  }

  public function viewGroup() {

  }

  public function addGroup() {

  }

  public function editGroup() {

  }

  public function deleteGroup() {
    
  }

}
