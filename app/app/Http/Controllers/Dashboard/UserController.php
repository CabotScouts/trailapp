<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller {

  public function users() {
    $users = User::all();
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
      if($request->id == $id) {
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
