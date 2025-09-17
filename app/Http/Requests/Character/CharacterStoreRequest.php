<?php

namespace App\Http\Requests\Character;

use App\Enums\CharacterClassEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CharacterStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'class' => ['required', Rule::enum(CharacterClassEnum::class)],
            'gender' => 'required|string|in:male,female',
            'skeletal_mesh_path' => 'nullable|string|max:255',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'User ID is required.',
            'user_id.exists' => 'The selected User ID does not exist.',
            'name.required' => 'The name field is required.',
            'name.max' => 'The name must not exceed 255 characters.',
            'skeletal_mesh_path.max' => 'The skeletal mesh path must not exceed 255 characters.',
        ];
    }
}
