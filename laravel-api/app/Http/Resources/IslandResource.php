<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IslandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'f_code' => $this->f_code,
            'atoll' => AtollResource::make($this->atoll),
            'name' => $this->name,
            'area_sqm' => $this->area_sqm,
            'island_category_id' => IslandCategoryResource::make($this->islandCategory),
        ];
    }
}
