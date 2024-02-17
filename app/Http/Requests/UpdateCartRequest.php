<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return !!\Auth::user();
    }
    public function attributes()
    {
        return [
            'quantity' => 'Кол-во'
        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product' => ['required', 'numeric', 'exists:App\Models\Product,id'],
            'quantity' => ['required', 'min:1', 'numeric'],
            'is_cart' => 'nullable||integer'
        ];
    }
}
