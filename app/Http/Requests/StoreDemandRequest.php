<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validation for publishing a Demand (merchant buy-offer).
 *
 * authorize() stays true — authz lives in policies + route middleware.
 */
class StoreDemandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * TODO(you) [Feature B]: rules for a demand. Mirror StoreOfferRequest —
     * title, category, quantity (int base unit), price (decimal → MoneyCast),
     * region, needed_by (nullable date), note (nullable). Price arrives as
     * major units; the MoneyCast converts to minor units on save.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        // TODO(you)
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'region' => ['required', 'string', 'max:255'],
            'needed_by' => ['nullable', 'date'],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
