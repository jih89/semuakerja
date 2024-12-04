<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'phone' => ['required', 'string', 'max:15'],
            'age' => ['required', 'integer', 'min:17', 'max:100'],
            'gender' => ['required', 'in:male,female'],
            'description' => ['required', 'string', 'max:1000'],
            'skills' => ['required', 'string', 'max:500'],
            'certificates' => ['required', 'string', 'max:500'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'phone.required' => 'Phone number is required',
            'phone.max' => 'Phone number must not exceed 15 characters',
            'age.required' => 'Age is required',
            'age.min' => 'Age must be at least 17 years',
            'age.max' => 'Age must not exceed 100 years',
            'gender.required' => 'Please select your gender',
            'description.required' => 'Brief description is required',
            'description.max' => 'Description must not exceed 1000 characters',
            'skills.required' => 'Please list your skills',
            'skills.max' => 'Skills must not exceed 500 characters',
            'certificates.required' => 'Please list your certificates',
            'certificates.max' => 'Certificates must not exceed 500 characters',
        ];
    }
}
