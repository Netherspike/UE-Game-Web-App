<?php

namespace App\Http\Requests\Character;

use App\Enums\CharacterClassEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MyCharacterStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:characters',
            'skeletal_mesh_path' => 'nullable|string|max:255',
            'class' => ['required', Rule::enum(CharacterClassEnum::class)],
            'gender' => 'required|string|in:male,female',
        ];
    }
}
