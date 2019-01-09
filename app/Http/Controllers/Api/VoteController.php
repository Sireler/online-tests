<?php

namespace App\Http\Controllers\Api;

use App\SurveyVote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Responses as JsonResponses;

class VoteController extends Controller
{
    use JsonResponses;

    /**
     * Store result
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->get('data');
        $ip = $request->ip();
        $userAgent = $request->userAgent();
        $created = Carbon::now();

        $voted = SurveyVote::where('survey_id', '=', $data[0]['survey_id'])->where('ip', $ip)->first();

        if (!$voted) {
            $b = array_map(function ($el) use($ip, $userAgent, $created) {
                return [
                    'survey_id' => $el['survey_id'],
                    'survey_question_id' => $el['survey_question_id'],
                    'survey_answer_id' => $el['survey_answer_id'],
                    'ip' => $ip,
                    'userAgent' => $userAgent,
                    'created_at' => $created
                ];
            }, $data);

            $votes = SurveyVote::insert($b);

            if ($votes == true) {
                return response()->json([
                    'status' => true,
                    'message' => 'Created'
                ], 201);
            } else {
                $this->forbiddenResponse();
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'You have already completed the survey'
            ], 403);
        }
    }

    /**
     * Check availability for a specific user
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function check(Request $request, int $id)
    {
        $ip = $request->ip();

        $voted = SurveyVote::where('survey_id', '=', $id)->where('ip', $ip)->first();

        if (!$voted) {
            return response()->json([
                'status' => true,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'You have already completed the survey'
            ], 403);
        }
    }
}
