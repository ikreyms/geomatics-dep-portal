<?php

namespace App\Http\Requests\Atoll;

use Illuminate\Foundation\Http\FormRequest;

class StoreAtollRequest extends FormRequest
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
            'short_name' => [
                'required',
                'string',
                'unique:atolls,short_name',
                'regex:/^[a-zA-Z0-9 ]+$/',
            ],
            'abbreviation' => [
                'required',
                'string',
                'unique:atolls,abbreviation',
                'regex:/^[a-zA-Z0-9]+$/',
                'max:4',
            ],
        ];
    }
}
