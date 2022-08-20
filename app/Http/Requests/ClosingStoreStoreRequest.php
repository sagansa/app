<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClosingStoreStoreRequest extends FormRequest
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
            'store_id' => ['required', 'exists:stores,id'],
            'shift_store_id' => ['required', 'exists:shift_stores,id'],
            'date' => ['required', 'date'],
            'cash_from_yesterday' => ['required'],
            'cash_for_tomorrow' => ['required'],
            'transfer_by_id' => ['required', 'exists:users,id'],
            'total_cash_transfer' => ['required'],
            'status' => ['required', 'max:255'],
            'created_by_id' => ['nullable', 'exists:users,id'],
            'approved_by_id' => ['nullable', 'exists:users,id'],
            'notes' => ['nullable', 'max:255', 'string'],
        ];
    }
}
