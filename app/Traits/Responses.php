<?php

namespace App\Traits;

trait Responses {
    private function forbiddenResponse()
    {
        return response()->json([
            'status' => false,
            'message' => 'Forbidden'
        ], 403);
    }

    private function errorResponse()
    {
        return response()->json([
            'status' => false,
            'message' => 'Unprocessable Entity'
        ], 422);
    }
}



