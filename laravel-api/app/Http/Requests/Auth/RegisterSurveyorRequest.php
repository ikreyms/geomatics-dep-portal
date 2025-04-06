<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterSurveyorRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:users,email'],

            'first_name' => ['required', 'string', 'regex:/^[a-zA-Z ]+$/'],
            'middle_name' => ['nullable', 'string', 'regex:/^[a-zA-Z ]+$/'],
            'last_name' => ['required', 'string', 'regex:/^[a-zA-Z ]+$/'],
            'nid' => ['required', 'string', 'unique:surveyor_profiles,nid', 'regex:/^A\d{6}$/'],
            'surveyor_reg_no' => ['required', 'string', 'unique:surveyor_profiles,surveyor_reg_no', 'regex:/^BP\d{7}$/'],
            'contact_no' => ['required', 'string', 'regex:/^[79]\d{6}$/'],
        ];
    }
}
