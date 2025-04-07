<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
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

    protected function storeModel(FormRequest $request, string $actionClass, string $resourceClass, string $modelName = 'Model')
    {
        try {
            $data = $request->validated();
            $model = new $actionClass($data);
            return $resourceClass::make($model);
        } catch (\Exception $e) {
            $this->logError($e, "{$modelName} creation failed", $data ?? null);
            return $this->somethingWentWrong();
        }
    }

    protected function updateModel(FormRequest $request, Model $model, string $modelName = 'Model')
    {
        try {
            $data = $request->validated();
            $model->update($data);
            return response()->noContent();
        } catch (\Exception $e) {
            $this->logError($e, "{$modelName} update failed", $data ?? null);
            return $this->somethingWentWrong();
        }
    }

    protected function destroyModel(Model $model, $modelName = 'Model')
    {
        try {
            $model->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            $this->logError($e, "{$$modelName} deletion failed");
            return $this->somethingWentWrong();
        }
    }
}
