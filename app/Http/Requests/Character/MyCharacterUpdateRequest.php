<?php

namespace App\Http\Requests\Character;

use App\Enums\CharacterClassEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MyCharacterUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:30|unique:characters,name,' . $this->route('character')->id,
            'skeletal_mesh_path' => 'nullable|string|max:255',
            'class' => ['sometimes', Rule::enum(CharacterClassEnum::class)],
            'gender' => 'sometimes|string|in:male,female',
        ];
    }
}
