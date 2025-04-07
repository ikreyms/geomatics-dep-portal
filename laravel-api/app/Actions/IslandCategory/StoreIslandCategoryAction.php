<?php

namespace App\Actions\IslandCategory;

use App\Contracts\ControllerAction;
use App\Models\IslandCategory;

class StoreIslandCategoryAction implements ControllerAction
{
    public function __invoke(array $data)
    {
        $atoll = IslandCategory::create([
            'name' => strtolower($data['name']),
        ]);

        return $atoll;
    }
}