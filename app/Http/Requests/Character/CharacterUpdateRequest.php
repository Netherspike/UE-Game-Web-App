<?php

namespace App\Http\Requests\Character;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\CharacterClassEnum;
use Illuminate\Validation\Rule;

class CharacterUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'skeletal_mesh_path' => 'nullable|string|max:255',
            'gender' => 'sometimes|string|in:male,female',
            'class' => ['sometimes', Rule::enum(CharacterClassEnum::class)]
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required when provided.',
            'name.max' => 'The name must not exceed 255 characters.',
            'skeletal_mesh_path.max' => 'The skeletal mesh path must not exceed 255 characters.',
        ];
    }
}
