<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255', 'string'],
            'no_telp' => [
                'nullable',
                Rule::unique('customers', 'no_telp')->ignore($this->customer),
                'max:255',
                'string',
            ],
            'status' => ['required', 'in:1,2'],
        ];
    }
}
