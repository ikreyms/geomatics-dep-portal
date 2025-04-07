<?php

namespace App\Actions\Island;

use App\Contracts\ControllerAction;
use App\Models\Island;
use App\Services\IdEncoderService;

class StoreIslandAction implements ControllerAction
{
    public function __invoke(array $data)
    {
        $atollId = IdEncoderService::decodeHashid($data['atoll_id']);
        $islandCategoryId = IdEncoderService::decodeHashid($data['island_category_id']);
        
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