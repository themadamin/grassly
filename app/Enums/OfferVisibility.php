<?php

namespace App\Enums;

/**
 * Whether an offer is visible on the shared Market. Only PUBLIC offers appear
 * there (Feature 4); PRIVATE keeps it to the farmer's own screens. Same
 * backed-enum pattern as OfferStatus / Currency.
 */
enum OfferVisibility: string
{
    case PUBLIC = 'public';
    case PRIVATE = 'private';

    public function label(): string
    {
        return match ($this) {
            self::PUBLIC => 'Public',
            self::PRIVATE => 'Private',
        };
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
