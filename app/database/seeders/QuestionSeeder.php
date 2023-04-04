<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Question;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            "When is a door not a door?",
            "A clerk at a butcher shop stands five feet ten inches tall and wears size 13 sneakers. What does he weigh?",
            "The more you take, the more you leave behind. \"What am I?\"",
            "What has a head, a tail, is brown, and has no legs?",
            "David's father has three sons: Snap, Crackle, and _____?",
        ];


        $i = 1;
        foreach($questions as $question) {
            Question::create([
                'name' => "Question " . $i,
                'number' => $i,
                'question' => $question,
                'points' => 10,
            ]);

            $i++;
        }
    }
}
