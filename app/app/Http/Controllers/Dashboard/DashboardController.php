<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class DashboardController extends Controller {

  public function dashboard() {
    return Inertia::render('admin/dashboard');
  }

}
