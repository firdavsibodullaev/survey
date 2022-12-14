<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Respondent;
use App\Models\Survey;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Respondent::factory(3)->create();

        Survey::factory(2)->has(
            Question::factory(5)->has(
                Answer::factory(3),
                'answers'
            ),
            'questions')
            ->create();

        $this->call([
            QuestionOrderSeeder::class
        ]);

    }
}
