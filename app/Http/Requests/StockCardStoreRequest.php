<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockCardStoreRequest extends FormRequest
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
            'store_id' => ['required', 'exists:stores,id'],
            'user_id' => ['nullable', 'exists:users,id'],
        ];
    }
}
