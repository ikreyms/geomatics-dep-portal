<?php

namespace App\Http\Requests\Island;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIslandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $island = $this->route('island');

        return [
            'f_code' => [
                'sometimes',
                'string',
                Rule::unique('islands',
                'f_code')->ignore($island->id),
                'regex:/^LD\d{4}$/'
            ],
            'atoll_id' => [
                'sometimes',
                'string',
                'exists:atolls,hashid',
            ],
            'name' => [
                'sometimes',
                'string',
                'regex:/^[a-zA-Z ]+$/',
            ],
            'area_sqm' => [
                'nullable',
                'numeric',
            ],
            'island_category_id' => [
                'nullable',
                'string',
                'exists:island_categories,hashid',
            ],
        ];
    }
}
