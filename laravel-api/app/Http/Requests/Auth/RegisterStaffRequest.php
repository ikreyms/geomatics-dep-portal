<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class RegisterStaffRequest extends FormRequest
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
            'username' => ['required', 'string', 'unique:users,username', 'regex:/^[a-zA-Z0-9]+$/'],
            'email' => ['required', 'email', 'unique:users,email'],

            'first_name' => ['required', 'string', 'regex:/^[a-zA-Z ]+$/'],
            'middle_name' => ['nullable', 'string', 'regex:/^[a-zA-Z ]+$/'],
            'last_name' => ['required', 'string', 'regex:/^[a-zA-Z ]+$/'],
            'nid' => ['required', 'string', 'unique:staff_profiles,nid', 'regex:/^A\d{6}$/'],
            'staff_no' => ['required', 'string', 'unique:staff_profiles,staff_no', 'regex:/^S\d{4}$/'],
            'contact_no' => ['required', 'string', 'regex:/^[79]\d{6}$/'],
        ];
    }
}
