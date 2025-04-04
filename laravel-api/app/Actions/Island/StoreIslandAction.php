<?php

namespace App\Actions\Island;

use App\Models\Island;
use App\Services\IdEncoder;

class StoreIslandAction
{
    public static function run(array $data)
    {
        $atollId = IdEncoder::decodeHashid($data['atoll_id']);
        $islandCategoryId = IdEncoder::decodeHashid($data['island_category_id']);
        
        $island = Island::create([
            'f_code' => $data['f_code'],
            'atoll_id' => $atollId,
            'name' => $data['name'],
            'area_sqm' => $data['area_sqm'],
            'island_category_id' => $islandCategoryId,
        ]);

        return $island;
    }
}