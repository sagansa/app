<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleUpdateRequest extends FormRequest
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
            'image' => ['nullable', 'image'],
            'no_register' => ['required', 'max:15', 'string'],
            'type' => ['required', 'max:255'],
            'store_id' => ['required', 'exists:stores,id'],
            'user_id' => ['required', 'exists:users,id'],
            'status' => ['required', 'max:255'],
            'notes' => ['nullable', 'max:255', 'string'],
        ];
    }
}
