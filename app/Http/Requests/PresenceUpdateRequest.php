<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PresenceUpdateRequest extends FormRequest
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
            'closing_store_id' => ['required', 'exists:closing_stores,id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_type_id' => ['required', 'exists:payment_types,id'],
            'status' => ['required'],
            'created_by_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
