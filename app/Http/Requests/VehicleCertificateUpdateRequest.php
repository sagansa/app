<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleCertificateUpdateRequest extends FormRequest
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
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'BPKB' => ['required', 'max:255'],
            'STNK' => ['required', 'max:255'],
            'name' => ['required', 'max:255', 'string'],
            'brand' => ['required', 'max:255', 'string'],
            'type' => ['required', 'max:255', 'string'],
            'category' => ['required', 'max:255', 'string'],
            'model' => ['required', 'max:255', 'string'],
            'manufacture_year' => ['required', 'numeric'],
            'cylinder_capacity' => ['required', 'max:255', 'string'],
            'vehilce_identity_no' => ['required', 'max:255', 'string'],
            'engine_no' => ['required', 'max:255', 'string'],
            'color' => ['required', 'max:255'],
            'type_fuel' => ['required', 'max:255', 'string'],
            'lisence_plate_color' => ['required', 'max:255', 'string'],
            'registration_year' => ['required', 'max:255', 'string'],
            'bpkb_no' => ['required', 'max:255', 'string'],
            'location_code' => ['required', 'max:255', 'string'],
            'registration_queue_no' => ['required', 'max:255', 'string'],
            'notes' => ['nullable', 'max:255', 'string'],
        ];
    }
}
