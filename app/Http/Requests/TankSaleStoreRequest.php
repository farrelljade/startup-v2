<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TankSaleStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'prospect_id' => ['required', 'integer', 'exists:prospects,id'],
            'customer_id' => ['nullable', 'integer', 'exists:customers,id'],
            'requested_by' => ['required', 'string'],
            'requested_by_email' => ['required', 'email'],
            'requested_at' => ['required', 'date'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['required', 'email', 'max:255'],
            'contact_phone' => ['required', 'string', 'max:255'],
            'requirement_urgent' => ['nullable', 'boolean'],
            'timeline' => ['required', 'string'],
            'fuel_type' => ['required', 'string'],
            'tank_type' => ['required', 'string'],
            'tank_size' => ['required', 'string'],
            'tank_location' => ['required', 'string'],
            'additional_requirements' => ['nullable', 'string'],
            'quotes' => ['nullable', 'string'],
        ];
    }
}
