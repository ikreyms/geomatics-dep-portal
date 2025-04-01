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
        try {
            $data = $request->validated();
            $islandCategory = StoreIslandCategoryAction::run($data);
            return IslandCategoryResource::make($islandCategory);
        } catch (\Exception $e) {
            $this->logError($e, 'Island category creation failed', $data);
            return $this->somethingWentWrong();
        }
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
        try {
            $data = $request->validated();
            $island_category->update($data);
            return response()->noContent();
        } catch (\Exception $e) {
            $this->logError($e, 'Island category update failed', $data ?? null);
            return $this->somethingWentWrong();
        }
    }

    public function destroy(IslandCategory $island_category)
    {
        try {
            $island_category->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            $this->logError($e, 'Island category deletion failed');
            return $this->somethingWentWrong();
        }
    }
}
