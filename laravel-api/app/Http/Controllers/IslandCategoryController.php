<?php

namespace App\Http\Controllers;

use App\Actions\IslandCategory\StoreIslandCategoryAction;
use App\Http\Requests\IslandCategory\StoreIslandCategoryRequest;
use App\Http\Requests\IslandCategory\UpdateIslandCategoryRequest;
use App\Http\Resources\IslandCategoryResource;
use App\Models\IslandCategory;

class IslandCategoryController extends Controller
{
    public function store(StoreIslandCategoryRequest $request)
    {
        return $this->storeModel(
            $request, 
            StoreIslandCategoryAction::class, 
            IslandCategoryResource::class, 
            'Island category'
        );
    }

    public function index()
    {
        return IslandCategoryResource::collection(IslandCategory::all());
    }
    
    public function show(IslandCategory $island_category)
    {
        return IslandCategoryResource::make($island_category);
    }

    public function update(UpdateIslandCategoryRequest $request, IslandCategory $island_category)
    {
        return $this->updateModel($request, $island_category, 'Island category');
    }

    public function destroy(IslandCategory $island_category)
    {
        return $this->destroyModel($island_category);
    }
}
