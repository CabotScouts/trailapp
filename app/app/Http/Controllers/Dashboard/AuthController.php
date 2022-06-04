<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class AuthController extends Controller {

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
  
}
