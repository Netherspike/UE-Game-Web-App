<?php

namespace App\Http\Requests\Item;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\ItemTypeEnum;

class ItemValidationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'type' => ['required', new Enum(ItemTypeEnum::class)],
            'name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail_path' => 'nullable|string|max:255',
            'static_mesh_path' => 'nullable|string|max:255',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'type.required' => 'The item type is required.',
            'type.enum' => 'The selected item type is invalid.',
            'name.required' => 'The name is required.',
            'name.max' => 'The name must not exceed 255 characters.',
            'display_name.required' => 'The display name is required.',
            'display_name.max' => 'The display name must not exceed 255 characters.',
            'description.string' => 'The description must be a valid string.',
            'thumbnail_path.string' => 'The thumbnail path must be a valid string.',
            'thumbnail_path.max' => 'The thumbnail path must not exceed 255 characters.',
            'static_mesh_path.string' => 'The static mesh path must be a valid string.',
            'static_mesh_path.max' => 'The static mesh path must not exceed 255 characters.',
        ];
    }
}
