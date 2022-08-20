<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReceiptByItemLoyverseUpdateRequest extends FormRequest
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
            'receipt_number' => ['required', 'max:255', 'string'],
            'receipt_type' => ['required', 'max:255', 'string'],
            'category' => ['required', 'max:255', 'string'],
            'sku' => ['required', 'max:255', 'string'],
            'item' => ['required', 'max:255', 'string'],
            'variant' => ['required', 'max:255', 'string'],
            'modifiers_applied' => ['nullable', 'max:255', 'string'],
            'quantity' => ['required', 'numeric'],
            'gross_sales' => ['required', 'max:255', 'string'],
            'discounts' => ['required', 'max:255', 'string'],
            'net_sales' => ['required', 'max:255', 'string'],
            'cost_of_goods' => ['required', 'max:255', 'string'],
            'gross_profit' => ['required', 'max:255', 'string'],
            'taxes' => ['required', 'max:255', 'string'],
            'dining_option' => ['required', 'max:255', 'string'],
            'pos' => ['required', 'max:255', 'string'],
            'store' => ['required', 'max:255', 'string'],
            'cashier_name' => ['required', 'max:255', 'string'],
            'customer_name' => ['nullable', 'max:255', 'string'],
            'customer_contacts' => ['nullable', 'max:255', 'string'],
            'comment' => ['nullable', 'max:255', 'string'],
            'status' => ['required', 'max:255', 'string'],
        ];
    }
}
