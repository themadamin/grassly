<?php

namespace App\Enums;

/**
 * The delivery lifecycle of an Order (a claim against an Offer).
 *
 * Per the claim model (CLAUDE.md → Domain model): offers are fixed price →
 * instant claim, so there is NO pending/approved/declined. Status is purely a
 * delivery lifecycle: placed → accepted → packing → in_transit → delivered,
 * plus a terminal `cancelled`.
 *
 * Scaffolded to mirror App\Enums\OfferStatus. The cases are the spec'd
 * lifecycle; tweak the labels/order if you refine the flow.
 */
enum OrderStatus: string
{
    case PLACED = 'placed';
    case ACCEPTED = 'accepted';
    case PACKING = 'packing';
    case IN_TRANSIT = 'in_transit';
    case DELIVERED = 'delivered';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::PLACED => 'Placed',
            self::ACCEPTED => 'Accepted',
            self::PACKING => 'Packing',
            self::IN_TRANSIT => 'In transit',
            self::DELIVERED => 'Delivered',
            self::CANCELLED => 'Cancelled',
        };
    }

    /**
     * The forward delivery steps (excludes the terminal `cancelled`), in order.
     * The frontend step-tracker renders these; keep them in lifecycle order.
     *
     * @return array<int, self>
     */
    public static function lifecycle(): array
    {
        return [
            self::PLACED,
            self::ACCEPTED,
            self::PACKING,
            self::IN_TRANSIT,
            self::DELIVERED,
        ];
    }

    /**
     * TODO(you) [Milestone A.4]: this is where the lifecycle GUARD lives — given
     * the current status, which statuses may it transition to? e.g. PLACED can
     * go to ACCEPTED or CANCELLED; DELIVERED is terminal. Return the allowed
     * next statuses and enforce it in the controller + policy.
     * Concept: a match() over $this returning an array of allowed self cases.
     *
     * @return array<int, self>
     */
    public function allowedTransitions(): array
    {
        // TODO(you)
        return [];
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
