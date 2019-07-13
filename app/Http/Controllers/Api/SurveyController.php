<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\Responses;
use Illuminate\Http\Request;
use App\Survey;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    use Responses;

    public function __construct()
    {
        $this->middleware('auth:api')->except('start');
    }

    /**
     * Get all surveys of the user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'surveys' => $user->surveys
        ]);
    }

    /**
     * Surveys that have at least one question.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function home(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'surveys' => $user->surveys()->has('questions')->get()
        ]);
    }

    /**
     * Get a survey with questions and answers
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function start(int $id)
    {
        $survey = Survey::where('id', '=', $id)->with('questions.answers')->firstOrFail();

        return response()->json([
            'status' => true,
            'survey' => $survey
        ]);
    }

    /**
     * Store a new survey
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'title' => 'required'
        ]);

        $user = $request->user();

        $survey = $user->surveys()->create([
            'title' => $data['title']
        ]);

        return response()->json([
            'status' => true,
            'data' => collect($survey)->only('id', 'title'),
            'message' => 'Survey created'
        ], 201);
    }

    /**
     * Delete a survey
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, int $id)
    {
        $user = $this->guard()->user();

        if ($user->hasSurvey($id)) {
            Survey::destroy($id);

            return response()->json([
                'status' => true,
                'message' => 'Survey deleted'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Forbidden'
            ], 403);
        }
    }

    /**
     * Get survey by id
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request, int $id)
    {
        $user = $request->user();

        if ($user->hasSurvey($id)) {
            $survey = Survey::where('id', '=', $id)->get(['title', 'created_at']);

            return response()->json([
                'status' => true,
                'survey' => $survey
            ], 200);
        } else {
            return $this->forbiddenResponse();
        }
    }

    /**
     * Update model fields
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        $user = $request->user();

        if ($user->hasSurvey($id)) {
            $fields = $request->all();

            $survey = Survey::find($id);

            $survey->fill($fields)->save();

            return response()->json([
                'status' => true,
                'message' => 'Survey updated'
            ], 202);
        } else {
            return $this->forbiddenResponse();
        }
    }
}
