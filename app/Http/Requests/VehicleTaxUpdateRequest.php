<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleTaxUpdateRequest extends FormRequest
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
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'amount_tax' => ['required', 'max:255'],
            'expired_date' => ['required', 'date'],
            'notes' => ['nullable', 'max:255', 'string'],
        ];
    }
}
