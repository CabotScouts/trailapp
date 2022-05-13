<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class AdminController extends Controller {
  
  public function login(Request $request) {
    if($request->isMethod('get')) {
      return Inertia::render('admin/login', [
        'name' => config('app.name'),
      ]);
    }
    elseif($request->isMethod('post')) {
      // do login
      return "reached form submit";
    }
    else {
      // how?
      return redirect()->route('login');
    }
  }
  
  public function logout(Request $request) {
    
  }
  
  public function dashboard(Request $request) {
    
  }
  
}
