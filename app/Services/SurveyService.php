<?php

namespace App\Services;

class SurveyService
{
    /**
     * @param array $payload
     * @return string[]
     */
    public function answer(array $payload): array
    {
        $question = app(QuestionService::class)->findById($payload['question_id']);

        $question->response()->create([
            "answer_id" => $payload["answer_id"],
            "user_id" => auth()->id()
        ]);

        return ["message" => "Answered successfully"];
    }
}
