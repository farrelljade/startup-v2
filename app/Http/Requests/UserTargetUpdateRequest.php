<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserTargetUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'target_value' => ['required', 'numeric', 'min:0']
        ];
    }
}
