<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRentalPackageRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'duration_hours' => 'required|integer|min:1|max:24',
            'price' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Package name is required.',
            'duration_hours.required' => 'Duration in hours is required.',
            'duration_hours.integer' => 'Duration must be a whole number of hours.',
            'duration_hours.min' => 'Minimum duration is 1 hour.',
            'duration_hours.max' => 'Maximum duration is 24 hours.',
            'price.required' => 'Package price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price cannot be negative.',
        ];
    }
}