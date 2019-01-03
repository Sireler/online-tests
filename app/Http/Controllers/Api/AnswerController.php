<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\SurveyAnswer;
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
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, int $id)
    {
        $user = $request->user();

        if ($user->hasSurvey($id)) {
            $answer = SurveyAnswer::find($id);
            $answer->delete();

            return response()->json([
                'status' => true,
                'message' => 'Answer deleted'
            ]);
        } else {
            $this->forbiddenResponse();
        }
    }
}
