<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UtilityStoreRequest extends FormRequest
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
            'number' => [
                'required',
                'unique:utilities,number',
                'max:255',
                'string',
            ],
            'name' => ['required', 'max:255', 'string'],
            'store_id' => ['required', 'exists:stores,id'],
            'category' => ['required', 'max:255'],
            'unit_id' => ['required', 'exists:units,id'],
            'utility_provider_id' => [
                'required',
                'exists:utility_providers,id',
            ],
            'pre_post' => ['required', 'max:255'],
            'status' => ['required', 'max:255'],
        ];
    }
}
