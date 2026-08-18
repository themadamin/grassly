<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{
    /**
     * Authorize the request. Runs BEFORE rules(); returning false → 403.
     */
    public function authorize(): bool
    {
        // Authorization lives in policies + route middleware, not here.
        return true;
    }

    /**
     * Validation rules (moved verbatim from ProductController@store).
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            // Closed list — must be one of the seeded crops (CropSeeder), no
            // free-typing a new crop.
            'crop_id' => ['required', 'integer', Rule::exists('crops', 'id')],
            'notes' => ['nullable', 'string'],
        ];
    }
}
