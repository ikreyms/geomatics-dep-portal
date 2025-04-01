<?php

namespace App\Http\Requests\Atoll;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAtollRequest extends FormRequest
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
        $atoll = $this->route('atoll');

        return [
            'short_name' => [
                'required',
                'string', 
                Rule::unique('atolls', 'short_name')->ignore($atoll->id)
            ],
            'abbreviation' => [
                'required',
                'string',
                'max:3',
                Rule::unique('atolls', 'abbreviation')->ignore($atoll->id),
            ],
        ];
    }
}
