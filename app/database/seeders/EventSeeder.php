<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Event;
use App\Models\Question;
use App\Models\Challenge;
use App\Models\Group;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create a new active event
        $event = Event::create([
            'name' => 'Example Event',
            'active' => true,
            'running' => true,
        ]);

        // Update questions/challenges/groups to reference this event
        Question::where('event_id', NULL)->update(['event_id' => $event->id]);
        Challenge::where('event_id', NULL)->update(['event_id' => $event->id]);
        Group::where('event_id', NULL)->update(['event_id' => $event->id]);
    }
}
