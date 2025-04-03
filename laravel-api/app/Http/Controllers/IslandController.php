<?php

namespace App\Http\Controllers;

use App\Actions\Island\StoreIslandAction;
use App\Http\Requests\Island\StoreIslandRequest;
use App\Http\Resources\IslandResource;

class IslandController extends Controller
{
    public function store(StoreIslandRequest $request)
    {
        return $this->storeModel(
            $request, 
            StoreIslandAction::class, 
            IslandResource::class, 
            'Island'
        );
    }

    // public function index()
    // {
    //     return AtollResource::collection(Atoll::all());
    // }
    
    // public function show(Atoll $atoll)
    // {
    //     return AtollResource::make($atoll);
    // }

    // public function update(UpdateAtollRequest $request, Atoll $atoll)
    // {
    //     return $this->updateModel($request, $atoll, 'Atoll');
    // }

    // public function destroy(Atoll $atoll)
    // {
    //     return $this->destroyModel($atoll);
    // }
}
