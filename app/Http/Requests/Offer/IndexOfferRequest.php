<?php

namespace App\Http\Requests\Offer;

use App\Enums\Currency;
use App\Enums\OfferSortOption;
use App\Enums\OfferStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validates + ALLOW-LISTS the offer index's query params. This is the security
 * gate for the filter engine: only the keys listed in rules() are ever returned
 * by validated(), so any other query param (a stray column name, a bogus sort)
 * simply never reaches a pipe. An out-of-range enum/sort value 422s instead of
 * being silently ignored.
 *
 * NOTE (repo convention): authorize() stays `true` here — the "farmers only"
 * gate lives in route middleware (`role:farmer` on offers.index), not in the
 * request. See docs/coding-rules.md → "FormRequest authorize() always return
 * true; authorization lives in policies + route middleware".
 */
class IndexOfferRequest extends FormRequest
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
        // Price bounds arrive as DECIMAL major units (dollars) — same unit the
        // create form takes — and are normalized to integer minor units when the
        // DTO is built (OfferFilterData::fromRequest). Cap them at the currency's
        // max so a filter can't be wider than any storable price.
        $currency = Currency::USD;

        return [
            // "all" from the segmented control means "no status filter" — the UI
            // omits the param entirely, so `nullable` + the enum rule is enough.
            'status' => ['nullable', Rule::enum(OfferStatus::class)],
            'search' => ['nullable', 'string', 'max:255'],
            'price_min' => ['nullable', 'numeric', 'min:0', 'max:'.$currency->maxMajorUnits()],
            'price_max' => ['nullable', 'numeric', 'min:0', 'max:'.$currency->maxMajorUnits()],
            // product_id must exist; ownership is enforced by the base scope, not
            // here (a merchant can't reach this action at all — see middleware).
            'product_id' => ['nullable', 'integer', Rule::exists('products', 'id')],
            // Closed list — an id, same pattern as product_id above.
            'region' => ['nullable', 'integer', Rule::exists('regions', 'id')],
            // Only these exact sort keys are legal; anything else 422s.
            'sort' => ['nullable', Rule::in(OfferSortOption::values())],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}
