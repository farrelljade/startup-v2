<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserTargetStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'targets' => ['required', 'array'],
            'targets.*.user_id' => ['required', 'exists:users,id'],
            'targets.*.type' => ['required', 'in:prospects,rejuves,lubricants,profit,iho'],
            'targets.*.value' => ['required', 'numeric', 'min:0'],
            'targets.*.start_date' => ['required', 'date'],
            'targets.*.end_date' => ['required', 'date', 'after:start_date'],
        ];
    }
}
