<?php

namespace App\Http\Requests\BookingFacility;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingFacility extends FormRequest
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
            "user_id" => "nullable",
            "total_price" => "required|numeric",
            "total_payment" => "required|numeric",
            "total_return" => "required|numeric",
        ];
    }
}
