<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
     * Validation rules. Mirrors StoreProductRequest.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'region' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
