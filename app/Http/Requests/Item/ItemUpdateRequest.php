<?php

namespace App\Http\Requests\Item;

use App\Enums\ItemTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ItemUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'type' => ['sometimes', 'required', new Enum(ItemTypeEnum::class)],
            'name' => 'sometimes|required|string|max:255',
            'display_name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail_path' => 'nullable|file|image|max:2048',
            'static_mesh_path' => 'nullable|string|max:255',
            'value' => 'nullable|integer'
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'type.required' => 'The item type is required when provided.',
            'type.enum' => 'The selected item type is invalid.',
            'name.required' => 'The name is required when provided.',
            'name.max' => 'The name must not exceed 255 characters.',
            'display_name.required' => 'The display name is required when provided.',
            'display_name.max' => 'The display name must not exceed 255 characters.',
            'thumbnail_path.file' => 'The thumbnail must be a valid file.',
            'thumbnail_path.image' => 'The thumbnail must be an image.',
            'thumbnail_path.max' => 'The thumbnail size must not exceed 2MB.',
        ];
    }
}
