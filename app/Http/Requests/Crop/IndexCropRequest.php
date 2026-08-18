<?php

namespace App\Http\Requests\Crop;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validates + allow-lists the crop typeahead's query params. Same convention
 * as IndexOfferRequest: only listed keys are ever returned by validated().
 */
class IndexCropRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['nullable', 'integer', Rule::exists('categories', 'id')],
            'query' => ['nullable', 'string', 'max:100'],
        ];
    }
}
