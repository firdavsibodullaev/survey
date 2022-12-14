<?php

namespace App\Http\Controllers;


use App\Enums\SurveyMessage;
use App\Http\Requests\InputRequest;
use App\Http\Resources\QuestionResource;
use App\Services\QuestionService;
use App\Services\SurveyService;
use Illuminate\Http\JsonResponse;

class WebhookController extends Controller
{
    public function __construct(private readonly SurveyService $surveyService)
    {
    }

    /**
     * @param InputRequest $request
     * @return JsonResponse|QuestionResource
     */
    public function input(InputRequest $request): JsonResponse|QuestionResource
    {
        $this->surveyService->answer($request->validated());

        $next_question = app(QuestionService::class)
            ->getNextQuestion(
                $request->get('question_id'),
                $request->get('next_question_id')
            );

        return $next_question
            ? QuestionResource::make($next_question)
            : response()->json([
                "message" => SurveyMessage::SURVEY_FINISHED->value
            ]);
    }
}
