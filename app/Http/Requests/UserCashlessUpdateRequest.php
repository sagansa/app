<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCashlessUpdateRequest extends FormRequest
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
            'admin_cashless_id' => ['nullable', 'exists:admin_cashlesses,id'],
            'store_id' => ['exists:stores,id', 'nullable'],
            'email' => ['nullable', 'email'],
            'username' => ['nullable', 'max:50', 'string'],
            'no_telp' => ['nullable', 'max:255', 'string'],
            'password' => ['nullable'],
        ];
    }
}
