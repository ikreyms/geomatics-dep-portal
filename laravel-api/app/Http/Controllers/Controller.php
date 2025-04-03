<?php

namespace App\Http\Controllers;

use App\Contracts\ControllerAction;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
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

    protected function storeModel(FormRequest $request, string $actionClass, string $resourceClass, string $modelName = 'Model')
    {
        try {
            $data = $request->validated();
            $model = $actionClass::run($data);
            return $resourceClass::make($model);
        } catch (\Exception $e) {
            $this->logError($e, "{$modelName} creation failed", $data);
            return $this->somethingWentWrong();
        }
    }

    protected function updateModel(FormRequest $request, string $actionClass, string $resourceClass, string $modelName = 'Model')
    {
        // try {
        //     $data = $request->validated();
        //     $atoll->update($data);
        //     return response()->noContent();
        // } catch (\Exception $e) {
        //     $this->logError($e, 'Atoll update failed', $data ?? null);
        //     return $this->somethingWentWrong();
        // }
    }
}
