<?php

namespace App\Actions\Island;

use App\Models\Island;

class StoreIslandAction
{
    public static function run(array $data)
    {
        $island = Island::create([
            'f_code' => $data['f_code'],
            'atoll_id' => $data['atoll_id'],
            'name' => $data['name'],
            'area_sqm' => $data['area_sqm'],
            'island_category_id' => $data['island_category'],
        ]);

        return $island;
    }
}