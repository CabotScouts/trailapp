<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Http\Controllers\Controller;
use App\Models\Event;

class EventController extends Controller {

  public function events() {
    // return Inertia::render('admin/event/list');
  }
  
}
