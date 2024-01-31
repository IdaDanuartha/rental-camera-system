<?php

namespace App\Http\Requests\DeviceSeries;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeviceSeriesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [            
			'device_brand_id' => 'required|numeric',
			'name' => 'required|string|max:50|unique:device_series,name,' . $this->series->id
        ];
    }

    public function attributes()
    {
        return [
            'device_brand_id' => 'device brand'
        ];
    }
}
