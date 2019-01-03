<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
     *
     */
    public function delete(Request $request, $id)
    {
        $user = $request->user();

        if ($user->hasSurvey($id)) {
            //todo
        } else {
            $this->forbiddenResponse();
        }
    }
}
