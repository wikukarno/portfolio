<?php

namespace App\Http\Requests\TechStack;

use Illuminate\Foundation\Http\FormRequest;

class StoreTechStackRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:tech_stacks,slug',
            'icon' => 'nullable|file|mimes:svg,png|max:2048',
        ];
    }
}
