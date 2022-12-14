<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\Survey;
use Illuminate\Database\Seeder;

class QuestionOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Survey::query()
            ->with('questions')
            ->get()
            ->each(function (Survey $survey) {
                $survey->questions->each(function (Question $question, $key) use ($survey) {
                    $question->next_question_id = $survey->questions->get($key + 1)?->id;
                    $question->save();
                });
            });
    }
}
