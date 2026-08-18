<?php

namespace App\Http\Requests\Market;

use App\Enums\Currency;
use App\Enums\MarketSortOption;
use App\Enums\MarketTab;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validates + allow-lists the Market's query params. Same convention as
 * IndexOfferRequest — only listed keys ever reach validated(), so nothing
 * unexpected reaches a filter pipe; a bad enum/sort value 422s.
 */
class IndexMarketRequest extends FormRequest
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
        $currency = Currency::USD;

        return [
            'search' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'integer', Rule::exists('categories', 'id')],
            'crop' => ['nullable', 'integer', Rule::exists('crops', 'id')],
            // Closed list — an id, same pattern as category/crop above.
            'region' => ['nullable', 'integer', Rule::exists('regions', 'id')],
            // Only one value today (a "live right now" quick filter); the
            // explicit date_from/date_to range below covers everything else.
            'availability' => ['nullable', Rule::in(['available_now'])],
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
            'price_min' => ['nullable', 'numeric', 'min:0', 'max:'.$currency->maxMajorUnits()],
            'price_max' => ['nullable', 'numeric', 'min:0', 'max:'.$currency->maxMajorUnits()],
            'sort' => ['nullable', Rule::in(MarketSortOption::values())],
            'tab' => ['nullable', Rule::enum(MarketTab::class)],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}
