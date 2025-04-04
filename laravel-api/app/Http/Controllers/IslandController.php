<?php

namespace App\Http\Controllers;

use App\Models\Island;
use App\Http\Resources\IslandResource;
use App\Actions\Island\StoreIslandAction;
use App\Http\Requests\Island\StoreIslandRequest;
use App\Http\Requests\Island\UpdateIslandRequest;

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

    public function update(UpdateIslandRequest $request, Island $island)
    {
        return $this->updateModel($request, $island, 'Island');
    }

    public function destroy(Island $island)
    {
        return $this->destroyModel($island);
    }
}
