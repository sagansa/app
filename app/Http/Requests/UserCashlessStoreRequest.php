<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCashlessStoreRequest extends FormRequest
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
            'cashless_provider_id' => [
                'required',
                'exists:cashless_providers,id',
            ],
            'store_id' => ['required', 'exists:stores,id'],
            'store_cashless_id' => ['required', 'exists:store_cashlesses,id'],
            'email' => ['nullable', 'email'],
            'username' => ['nullable', 'max:50', 'string'],
            'no_telp' => ['nullable', 'max:255', 'string'],
            'password' => ['nullable'],
            'status' => ['required', 'max:255'],
        ];
    }
}
