<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProspectStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users,id'],
            'company_name' => ['required', 'string', 'max:255'],
            'lead_source_id' => ['required', 'exists:lead_source,id'],
            'email' => ['required', 'email', 'max:255'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_role' => ['nullable', 'string'],
            'phone' => ['required', 'string', 'max:255'],
            'line_1' => ['required', 'string', 'max:255'],
            'line_2' => ['nullable', 'string', 'max:255'],
            'line_3' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'county' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['required', 'string'],
            'status' => ['required', 'string']
        ];
    }

//    public function attributes()
//    {
//        return [
//            'user_id' => 'account manager'
//        ];
//    }

    public function messages()
    {
        return [
            'user_id.required' => 'The account manager field is required.',
            'lead_source_id.required' => 'The lead source field is required.'
        ];
    }
}
