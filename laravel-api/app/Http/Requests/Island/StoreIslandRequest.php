<?php

namespace App\Http\Requests\Island;

use Illuminate\Foundation\Http\FormRequest;

class StoreIslandRequest extends FormRequest
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
        return [
            'f_code' => ['required', 'string', 'regex:/^LD\d{4}$/'],
            'atoll_id' => ['required', 'exists:atolls'],
            'name' => ['required', 'string', 'regex:/^[a-zA-Z ]+$/'],
            'area_sqm' => ['nullable', 'float'],
            'island_category_id' => [],
        ];
    }
}
