<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
			'name' => ['required', 'string'],			
			'phone_number' => ['nullable', 'string', 'min:10', 'max:13'],			
			'profile_image' => ['nullable', 'file', 'image', 'mimes:png,jpg,jpeg,gif,svg,webp', 'max:2000'],
			'user.username' => ['required', 'alpha_dash', Rule::unique('users', 'username')->ignore(auth()->id())],
			'user.email' => ['required', 'email:dns', Rule::unique('users', 'email')->ignore(auth()->id())],
			'user.password' => ['nullable', 'min:6'],
        ];
    }

    public function attributes()
    {
        return [
            'user.username' => 'username',
            'user.email' => 'email',
            'user.password' => 'password',
            'user.status' => 'status',
        ];
    }
}
