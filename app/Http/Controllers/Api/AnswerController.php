<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Survey;
use App\SurveyAnswer;
use App\SurveyQuestion;
use Illuminate\Http\Request;
use App\Traits\Responses as JsonResponses;

class AnswerController extends Controller
{
    use JsonResponses;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Delete an answer
     * @param Request $request
     * @param int $surveyId
     * @param int $answerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, int $surveyId, int $answerId)
    {
        $user = $request->user();

        if ($user->hasSurvey($surveyId)) {
            $answer = SurveyAnswer::find($answerId);
            $answer->delete();

            return response()->json([
                'status' => true,
                'message' => 'Answer deleted'
            ]);
        } else {
            return $this->forbiddenResponse();
        }
    }

    /**
     * (dep)
     * TODO
     * Update answers
     *
     * @param Request $request
     * @param int $questionId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $questionId)
    {
        $data = $request->all();
        $user = $request->user();

        if ($user->hasQuestion($questionId)) {
            $answers = $data['answers'];

            $question = SurveyQuestion::find($questionId);

            $question->answers()->delete();
            $question->answers()->createMany($answers);

            return response()->json([
                'status' => true,
                'message' => 'Question updated'
            ]);
        } else {
            return $this->forbiddenResponse();
        }
    }
}
