<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuelServiceStoreRequest extends FormRequest
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
            'image' => ['nullable', 'image', 'max:1024'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'fuel_service' => ['required', 'in:1,2'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'km' => ['required', 'numeric'],
            'liter' => ['required', 'numeric'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'closing_store_id' => ['required', 'exists:closing_stores,id'],
        ];
    }
}
