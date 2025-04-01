<?php

namespace App\Actions\IslandCategory;

use App\Models\IslandCategory;

class StoreIslandCategoryAction
{
    public static function run(array $data)
    {
        $atoll = IslandCategory::create([
            'name' => $data['name'],
        ]);

        return $atoll;
    }
}