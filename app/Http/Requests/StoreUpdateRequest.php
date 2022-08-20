<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateRequest extends FormRequest
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
            'nickname' => ['required', 'max:255', 'string'],
            'name' => ['required', 'max:255', 'string'],
            'no_telp' => ['nullable', 'max:255', 'string'],
            'email' => [
                'required',
                Rule::unique('stores', 'email')->ignore($this->store),
                'email',
            ],
            'status' => ['required', 'max:255'],
        ];
    }
}
