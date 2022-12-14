<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParentAccountCashlessStoreRequest extends FormRequest
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
            'username' => ['nullable', 'max:255', 'string'],
            'password' => ['nullable'],
            'email' => ['nullable', 'email'],
            'no_telp' => ['nullable', 'string'],
        ];
    }
}
