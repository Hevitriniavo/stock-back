<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateArticleRequest extends FormRequest
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
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'unit_price' => 'required|numeric|min:0',
            'quantity_stock' => 'required|numeric|min:0',
            'category_id' => 'nullable|numeric',
            'category' => 'nullable|array',
            'category.id' => 'numeric',
            'category.name' => 'string|max:255',
        ];
    }
}
