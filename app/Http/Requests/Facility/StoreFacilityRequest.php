<?php

namespace App\Http\Requests\Facility;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFacilityRequest extends FormRequest
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
			"facility_type_id" => "required",
            "name" => "required|unique:facilities,name",
            "rental_price" => "required",
            "stock" => "required",
            "description" => "required",
            "images.*" => "required|file|image|mimes:png,jpg,jpeg,gif,webp,svg"
        ];
    }

    public function attributes()
    {
        return [
            "facility_type_id" => "facility type"
        ];
    }
}
