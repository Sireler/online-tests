<?php

namespace App\Traits;

trait Responses {

    /**
     * Forbidden response
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    private function forbiddenResponse($message = 'Forbidden')
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], 403);
    }

    /**
     * Unprocessable entity response
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    private function UEResponse($message = 'Unprocessable Entity')
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], 422);
    }

    /**
     * Unauthorized response
     *
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    private function UnauthorizedResponse($message = 'Unauthorized')
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], 401);
    }
}



