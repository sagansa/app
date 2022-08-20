<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'string'],
            'no_telp' => ['nullable', 'max:255', 'string'],
            'address' => ['nullable', 'max:255', 'string'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'regency_id' => ['nullable', 'exists:regencies,id'],
            'village_id' => ['nullable', 'exists:villages,id'],
            'district_id' => ['nullable', 'exists:districts,id'],
            'codepos' => ['nullable', 'numeric'],
            'bank_id' => ['nullable', 'exists:banks,id'],
            'bank_account_name' => ['nullable', 'max:255', 'string'],
            'bank_account_no' => ['nullable', 'max:255', 'string'],
            'status' => ['required', 'max:255'],
        ];
    }
}
