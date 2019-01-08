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
                'message' => 'You have either already completed the survey'
            ], 403);
        }


    }
}
