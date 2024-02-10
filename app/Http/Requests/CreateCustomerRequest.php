<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
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
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,webp',
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:150',
        ];
    }
}
