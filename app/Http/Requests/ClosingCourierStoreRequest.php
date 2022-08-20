<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClosingCourierStoreRequest extends FormRequest
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
            'bank_id' => ['required', 'exists:banks,id'],
            'total_cash_to_transfer' => ['required', 'min:0', 'numeric'],
            'status' => ['required'],
            'notes' => ['nullable', 'max:255', 'string'],
        ];
    }
}
