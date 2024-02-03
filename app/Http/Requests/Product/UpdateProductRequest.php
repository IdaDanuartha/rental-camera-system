<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
			"device_series_id" => "required",
            "name" => "required|unique:products,name," . $this->product->id,
            "rental_price" => "required",
            "stock" => "required",
            "description" => "required",
        ];
    }

    public function attributes()
    {
        return [
            "device_series_id" => "device series"
        ];
    }
}
