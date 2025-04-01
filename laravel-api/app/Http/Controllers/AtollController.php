<?php

namespace App\Http\Controllers;

use App\Models\Atoll;
use App\Http\Resources\AtollResource;
use App\Actions\Atoll\StoreAtollAction;
use App\Http\Requests\Atoll\StoreAtollRequest;
use App\Http\Requests\Atoll\UpdateAtollRequest;

class AtollController extends Controller
{
    public function store(StoreAtollRequest $request)
    {
        try {
            $data = $request->validated();
            $atoll = StoreAtollAction::run($data);
            return AtollResource::make($atoll);
        } catch (\Exception $e) {
            $this->logError($e, 'Atoll creation failed', $data);
            return $this->somethingWentWrong();
        }
    }

    public function index()
    {
        return AtollResource::collection(Atoll::all());
    }
    
    public function show(Atoll $atoll)
    {
        return AtollResource::make($atoll);
    }

    public function update(UpdateAtollRequest $request, Atoll $atoll)
    {
        try {
            $data = $request->validated();
            $atoll->update($data);
            return response()->noContent();
        } catch (\Exception $e) {
            $this->logError($e, 'Atoll update failed', $data ?? null);
            return $this->somethingWentWrong();
        }
    }

    public function destroy(Atoll $atoll)
    {
        try {
            $atoll->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            $this->logError($e, 'Atoll deletion failed');
            return $this->somethingWentWrong();
        }
    }
}
