<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Question;
use App\Models\Challenge;
use App\Models\Group;

class EventController extends Controller {

  public function events() {
    return Inertia::render('admin/event/list', [
      'events' => Event::all(),
    ]);
  }

  public function newEvent(Request $request) {
    if($request->isMethod('get')) {
      return Inertia::render('admin/event/form', [
        'events' => Event::all(),
        'event' => false,
      ]);
    } else {
      $data = $request->validate([
        'name' => 'required|string|max:255',
        'clone' => 'nullable|boolean',
        'clone_event_id' => 'required_if:clone,true|integer|exists:App\Models\Event,id',
        'clone_questions' => 'required_if:clone,true|boolean',
        'clone_challenges' => 'required_if:clone,true|boolean',
        'clone_groups' => 'required_if:clone,true|boolean'
      ]);

      // TODO: change validation method to add messages (particularly when cloning but no event chosen)

      $event = Event::create(['name' => $data["name"]]);

      if($data["clone"]) {
        $clone = Event::with(['questions', 'challenges', 'groups'])->find($data["clone_event_id"]);

        if($data["clone_questions"]) {
          foreach($clone->questions as $question) {
            $q = Question::create([
              'name' => $question->name,
              'number' => $question->number,
              'question' => $question->question,
              'points' => $question->points,
            ]);
            $event->questions()->save($q);
          }
        }

        if($data["clone_challenges"]) {
          foreach($clone->challenges as $challenge) {
            $c = Challenge::create([
              'name' => $challenge->name,
              'description' => $challenge->description,
              'points' => $challenge->points,
            ]);
            $event->challenges()->save($c);
          }
        }

        if($data["clone_groups"]) {
          foreach($clone->groups as $group) {
            $g = Group::create([
              'name' => $group->name,
              'number' => $group->number,
            ]);
            $event->groups()->save($g);
          }
        }
      }

      return redirect()->route('events');
    }
  }

  public function editEvent(Request $request, $id) {
    if($request->isMethod('get')) {
      $event = Event::findOrFail($id);
      return Inertia::render('admin/event/form', [
        'events' => false,
        'event' => $event,
      ]);
    } else {
      $event = Event::findOrFail($id);

      $data = $request->validate([
        'name' => 'required|string|max:255',
      ]);

      $event->update($data);
      return redirect()->route('events');
    }
  }

  public function deleteEvent(Request $request, $id) {
    if($request->isMethod('get')) {
      $event = Event::findOrFail($id);
      return Inertia::render('admin/event/delete', [
        'event' => $event
      ]);
    } else {
      $event = Event::findOrFail($id);

      if($event->active) {
        return back()->withErrors(['id' => 'You cannot delete the currently active event']);
      } else {
        $event->delete();
        return redirect()->route('events');
      }
    }
  }
  
  public function toggleActive(Request $request, $id) {
    if($request->isMethod('get')) {
      $event = Event::findOrFail($id);
      return Inertia::render('admin/event/toggle-active', [
        'event' => $event
      ]);
    } else {
      $activate = Event::findOrFail($id);

      $deactivate = Event::where('active', true)->first();
      $deactivate->running = false;
      $deactivate->active = false;
      $deactivate->save();

      $activate->active = true;
      $activate->running = false;
      $activate->save();

      return redirect()->route('events');
    }
  }

  public function toggleRunning(Request $request, $id) {
    if($request->isMethod('get')) {
      $event = Event::findOrFail($id);
      return Inertia::render('admin/event/toggle-running', [
        'event' => $event
      ]);
    } else {
      $event = Event::findOrFail($id);

      if(!$event->active) {
        return back()->withErrors(['id' => 'You cannot run an event that isn\'t the active event']);
      } else {
        $event->running = !$event->running;
        $event->save();
        return redirect()->route('events');
      }
      
    }
  }

}
