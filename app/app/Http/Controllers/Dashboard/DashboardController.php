<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Event;

class DashboardController extends Controller {

  public function dashboard() {
    $event = Event::where('active', true)->first();
    
    return Inertia::render('admin/dashboard', [
      'event' => $event,
    ]);
  }

}
