<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Survey;
use App\SurveyQuestion;
use Illuminate\Http\Request;
use App\Traits\Responses as JsonResponses;

class QuestionController extends Controller
{
    use JsonResponses;

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

                $question->load('answers');

                return response()->json([
                    'status' => true,
                    'question' => $question,
                    'message' => 'Successful creation'
                ], 201);
            } catch (\Exception $e) {
                return $this->UEResponse();
            }
        } else {
            return $this->forbiddenResponse();
        }
    }

    public function index(Request $request)
    {
        // todo index
    }

    /**
     * Get survey and answers
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request, int $id)
    {
        $user = $request->user();

        if ($user->hasSurvey($id)) {
            $survey = Survey::where('id', '=', $id)->with('questions.answers')->first();

            return response()->json($survey);
        } else {
            return $this->forbiddenResponse();
        }
    }

    /**
     * Delete a question
     *
     * @param Request $request
     * @param int $surveyId
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, int $surveyId, int $id)
    {
        $user = $request->user();

        if ($user->hasSurvey($surveyId)) {
            $question = SurveyQuestion::find($id);
            $question->delete();

            return response()->json([
                'status' => true,
                'message' => 'Question deleted'
            ]);
        } else {
            return $this->forbiddenResponse();
        }
    }
}
