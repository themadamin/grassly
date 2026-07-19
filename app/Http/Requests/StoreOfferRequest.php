<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use App\Enums\OfferVisibility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOfferRequest extends FormRequest
{
    /**
     * Authorize the request. Runs BEFORE rules(); returning false → 403.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        // Price is validated in DECIMAL major units (dollars); the model's
        // MoneyCast converts to integer minor units on save. `decimal:0,2`
        // enforces "no more than 2 decimals"; `max` comes from the Currency enum.
        $currency = Currency::USD;

        return [
            // Must be one of the current farmer's own products (scoping the
            // exists rule to user_id is the ownership guard for the FK).
            'product_id' => ['required', 'integer', Rule::exists('products', 'id')->where('user_id', $this->user()->id)],
            'title' => ['required', 'string', 'max:255'],
            // Quantity is an integer in `unit`. remaining_quantity is derived in
            // the controller (= total_quantity on create), not user input.
            'total_quantity' => ['required', 'integer', 'min:1'],
            'unit' => ['required', Rule::in(['kg', 'ton'])],
            'price' => ['required', 'numeric', 'min:0', 'max:'.$currency->maxMajorUnits(), 'decimal:0,'.$currency->decimals()],
            'region' => ['required', 'string'],
            'available_from' => ['required', 'date', 'after_or_equal:today'],
            'available_to' => ['nullable', 'date', 'after:available_from'],
            'description' => ['nullable', 'string'],
            'visibility' => ['required', Rule::enum(OfferVisibility::class)],
            'status' => ['required', Rule::enum(OfferStatus::class)],
        ];
    }
}
