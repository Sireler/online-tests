<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Survey;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Store a new question and answers
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $user = $request->user();

        $survey = Survey::findOrFail($data['survey_id']);

        if ($user->hasSurvey($data['survey_id'])) {
            try {
                $question = $survey->questions()->create($data['question']);

                $answers = $data['answers'];

                $question->answers()->createMany($answers);
            } catch (\Exception $e) {
                return $this->errorRequest();
            }

        } else {
            return $this->forbiddenResponse();
        }
    }

    private function forbiddenResponse()
    {
        return response()->json([
            'status' => false,
            'message' => 'Forbidden'
        ], 403);
    }

    private function errorRequest()
    {
        return response()->json([
            'status' => false,
            'message' => 'Unprocessable Entity'
        ], 422);
    }
}
