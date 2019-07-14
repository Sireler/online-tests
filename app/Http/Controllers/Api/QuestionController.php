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
        $user = $request->user();

        $survey = Survey::findOrFail($request->get('survey_id'));

        if ($user->can('update', $survey)) {
            try {
                $question = $survey->questions()
                    ->create($request->get('question'));

                $question->answers()
                    ->createMany($request->get('answers'));

                $question->load('answers');

                return response()->json([
                    'status' => true,
                    'question' => $question,
                    'message' => 'Created'
                ], 201);
            } catch (\Exception $e) {
                return $this->UEResponse();
            }
        } else {
            return $this->forbiddenResponse();
        }
    }

    /**
     * Update a question
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $user = $request->user();
        $question = SurveyQuestion::findOrFail($id);

        if ($user->can('update', $question)) {
            $question->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Updated'
            ]);
        } else {
            return $this->forbiddenResponse();
        }
    }

    /**
     * Get a survey and answers
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request, int $id)
    {
        $user = $request->user();
        $survey = Survey::where('id', $id)->with('questions.answers')->firstOrFail();

        if ($user->can('update', $survey)) {
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

        $question = SurveyQuestion::findOrFail($id);
        if ($user->can('delete', $question)) {
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
