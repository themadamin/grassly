<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use App\Enums\OfferVisibility;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOfferRequest extends FormRequest
{
    /**
     * Authorize the request. Runs BEFORE rules(); returning false → 403.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules. Mirrors StoreOfferRequest.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $currency = Currency::USD;

        return [
            'product_id' => ['required', 'integer', Rule::exists('products', 'id')->where('user_id', $this->user()->id)],
            'title' => ['required', 'string', 'max:255'],
            'total_quantity' => ['required', 'integer', 'min:1'],
            'unit' => ['required', Rule::in(['kg', 'ton'])],
            'price' => ['required', 'numeric', 'min:0', 'max:'.$currency->maxMajorUnits(), 'decimal:0,'.$currency->decimals()],
            'region_ids' => ['required', 'array', 'min:1'],
            'region_ids.*' => ['integer', Rule::exists('regions', 'id')],
            // NOTE: unlike StoreOfferRequest, `after_or_equal:today` is left OFF
            // available_from — editing an offer whose start is already past would
            // otherwise always fail.
            'available_from' => ['required', 'date'],
            'available_to' => ['nullable', 'date', 'after:available_from'],
            'description' => ['nullable', 'string'],
            'visibility' => ['required', Rule::enum(OfferVisibility::class)],
            'status' => ['required', Rule::enum(OfferStatus::class)],
        ];
    }
}
