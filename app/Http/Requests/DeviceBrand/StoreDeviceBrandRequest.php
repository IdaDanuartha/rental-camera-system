<?php

namespace App\Http\Requests\DeviceBrand;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeviceBrandRequest extends FormRequest
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
			'device_type_id' => 'required|numeric',
			'name' => 'required|string|max:50|unique:device_brands,name'
        ];
    }

    public function attributes()
    {
        return [
            'device_type_id' => 'device type'
        ];
    }
}
