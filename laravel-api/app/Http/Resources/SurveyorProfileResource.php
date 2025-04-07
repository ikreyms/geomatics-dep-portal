<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SurveyorProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->{config('hashid.field')},
            'first_name' => $this->first_name,
            'middle_name' => $this->whenNotNull($this->middle_name),
            'last_name' => $this->last_name,
            'nid' => $this->nid,
            'surveyor_reg_no' => $this->staff_no,
            'contact_no' => $this->contact_no,
        ];
    }
}
