<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRentalRequest extends FormRequest
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
            'console_id' => 'required|exists:consoles,id',
            'customer_id' => 'required|exists:customers,id',
            'rental_package_id' => 'nullable|exists:rental_packages,id',
            'duration_hours' => 'nullable|integer|min:1|max:24',
            'paid_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
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
            'console_id.required' => 'Please select a console.',
            'console_id.exists' => 'The selected console is not available.',
            'customer_id.required' => 'Please select a customer.',
            'customer_id.exists' => 'The selected customer does not exist.',
            'duration_hours.integer' => 'Duration must be a whole number of hours.',
            'duration_hours.min' => 'Minimum rental duration is 1 hour.',
            'duration_hours.max' => 'Maximum rental duration is 24 hours.',
            'paid_amount.numeric' => 'Paid amount must be a valid number.',
            'paid_amount.min' => 'Paid amount cannot be negative.',
        ];
    }
}