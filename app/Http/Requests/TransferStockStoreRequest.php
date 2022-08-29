<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferStockStoreRequest extends FormRequest
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
            'date' => ['required', 'date'],
            'from_store_id' => ['required', 'exists:stores,id'],
            'to_store_id' => ['required', 'exists:stores,id'],
            'status' => ['required', 'in:1,2,3,4'],
            'received_by_id' => ['required', 'exists:users,id'],
            'sent_by_id' => ['required', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
            'notes' => ['nullable', 'max:255', 'string'],
        ];
    }
}
