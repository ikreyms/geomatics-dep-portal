<?php

namespace App\Actions\IslandCategory;

use App\Contracts\ControllerAction;
use App\Models\IslandCategory;

class StoreIslandCategoryAction implements ControllerAction
{
    public static function handle(array $data)
    {
        $atoll = IslandCategory::create([
            'name' => strtolower($data['name']),
        ]);

        return $atoll;
    }
}