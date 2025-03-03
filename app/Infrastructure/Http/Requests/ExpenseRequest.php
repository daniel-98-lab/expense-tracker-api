<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
            'data.attributes.title' => ['required', 'string', 'max:255'],
            'data.attributes.description' => ['nullable', 'string', 'max:1000'],
            'data.attributes.amount' => ['required', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            'data.attributes.date' => ['required', 'date'],
            'data.relationships.user.data.id' => ['required', 'integer', 'exists:users,id'],
            'data.relationships.category.data.id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }
}
