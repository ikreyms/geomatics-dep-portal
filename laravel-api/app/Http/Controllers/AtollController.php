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
        return $this->storeModel(
            $request, 
            StoreAtollAction::class, 
            AtollResource::class, 
            'Atoll'
        );
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
        return $this->updateModel($request, $atoll, 'Atoll');
    }

    public function destroy(Atoll $atoll)
    {
        return $this->destroyModel($atoll);
    }
}
