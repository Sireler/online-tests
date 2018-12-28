<?php

namespace App\Traits;

trait Responses {

    /**
     * Forbidden response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function forbiddenResponse()
    {
        return response()->json([
            'status' => false,
            'message' => 'Forbidden'
        ], 403);
    }

    /**
     * Unprocessable entity response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function UEResponse()
    {
        return response()->json([
            'status' => false,
            'message' => 'Unprocessable Entity'
        ], 422);
    }
}



