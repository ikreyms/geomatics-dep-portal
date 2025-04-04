<?php

namespace App\Http\Controllers;

use App\Models\Island;
use App\Http\Resources\IslandResource;
use App\Actions\Island\StoreIslandAction;
use App\Http\Requests\Island\StoreIslandRequest;

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

    public function index()
    {
        return IslandResource::collection(Island::simplePaginate());
    }
    
    public function show(Island $island)
    {
        return IslandResource::make($island);
    }

    // public function update(UpdateAtollRequest $request, Atoll $atoll)
    // {
    //     return $this->updateModel($request, $atoll, 'Atoll');
    // }

    // public function destroy(Atoll $atoll)
    // {
    //     return $this->destroyModel($atoll);
    // }
}
