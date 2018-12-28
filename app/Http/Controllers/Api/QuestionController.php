<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Survey;
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

                return response()->json([
                    'status' => true,
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

        } else {
            return $this->forbiddenResponse();
        }
    }
}