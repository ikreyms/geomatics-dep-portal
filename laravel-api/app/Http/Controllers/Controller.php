<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

abstract class Controller
{
    protected function somethingWentWrong(): JsonResponse
    {
        return response()->json(['error' => 'Something went wrong. Please try again later.'], 422);
    }

    protected function logError(Exception $e, string $description, ?array $data = null)
    {
        Log::error($description, [
            'error' => $e->getMessage(),
            'exception' => $e,
            'data' => $data
        ]);
    }
}
