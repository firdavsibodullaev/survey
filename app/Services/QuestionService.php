<?php

namespace App\Services;

use App\Models\Question;

class QuestionService
{
    /**
     * @param int $id
     * @return Question
     */
    public function findById(int $id): Question
    {
        /** @var Question $question */
        $question = Question::query()->whereKey($id)->firstOrFail();

        return $question;
    }

    /**
     * @param array $payload
     * @return string[]
     */
    public function answer(array $payload): array
    {
        $question = $this->findById($payload['question_id']);

        $question->response()->create([
            "answer_id" => $payload["answer_id"],
            "user_id" => auth()->id()
        ]);

        return ["message" => "Answered successfully"];
    }

    /**
     * @param int $question_id
     * @param int|null $next_question_id
     * @return null|Question
     */
    public function getNextQuestion(int $question_id, ?int $next_question_id = null): ?Question
    {
        if ($next_question_id) {
            return $this->findById($next_question_id);
        }

        return $this->findById($question_id)->nextQuestion?->load('answers');
    }
}
