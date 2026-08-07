<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validation for placing a claim (Order) against an Offer.
 *
 * authorize() stays true — authorization is enforced by policies + route
 * middleware (`role:merchant`), never here.
 */
class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * TODO(you) [Milestone A.2]: the claim's validation rules. The critical one
     * is that `quantity` must be a positive integer that does NOT exceed the
     * target offer's `remaining_quantity` — otherwise a merchant could claim
     * more than exists. Concept: a Rule that reads the offer, or validate the
     * ceiling in the controller inside the DB transaction to avoid a race.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        // TODO(you)
        return [
            'offer_id' => ['required', 'integer', 'exists:offers,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'delivery_window' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
