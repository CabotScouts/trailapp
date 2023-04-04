<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Challenge;

class ChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $challenges = [
            [ "All You Need Is Love", "Take a photo of team members recreating the Abbey Road album cover.", ],
            [ "Don't Blink", "Take a photo of you impersonating a statue.", ],
            [ "New Phone Who Dis", "Take a selfie of your entire team.", ],
            [ "Wingardiuim Leviosa", "Take a photo of your entire team off the ground at the same time.", ],
        ];

        foreach($challenges as $challenge) {
            Challenge::create([
                'name' => $challenge[0],
                'description' => $challenge[1],
                'points' => 10,
            ]);
        }
    }
}
