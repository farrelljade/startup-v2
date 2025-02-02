<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TankSaleUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'contact_name' => ['string', 'max:255'],
            'requirement_urgent' => ['boolean'],
            'status' => ['required', 'string'],
        ];
    }
}
