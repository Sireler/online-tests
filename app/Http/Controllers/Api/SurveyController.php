<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Survey;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $user = $this->guard()->user();

        return response()->json([
            'surveys' => $user->surveys
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

        $user = $this->guard()->user();

        $created = $user->surveys()->create([
            'title' => $data['title']
        ]);

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $created->id,
                'title' => $created->title
            ],
            'message' => 'Survey created'
        ], 201);
    }

    /**
     * Delete survey
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
     * Check access and return survey
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(int $id)
    {
        $user = $this->guard()->user();

        if ($user->hasSurvey($id)) {
            $survey = Survey::where('id', '=', $id)->get(['title', 'created_at']);

            return response()->json([
                'status' => true,
                'survey' => $survey
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Forbidden'
            ], 403);
        }
    }

    /**
     * Current guard
     *
     * @return mixed
     */
    public function guard()
    {
        return Auth::guard();
    }
}
