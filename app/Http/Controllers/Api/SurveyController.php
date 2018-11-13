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
            'status' => 'Survey created',
            'data' => [
                'id' => $created->id,
                'title' => $created->title
            ]
        ], 201);
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
