<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexSearchRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'search' => 'nullable|string|max:255'
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'search.string' => 'The search term must be a valid string.',
            'search.max' => 'The search term must not exceed 255 characters.'
        ];
    }
}
