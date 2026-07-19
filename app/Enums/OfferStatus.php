<?php

namespace App\Enums;

enum OfferStatus: string
{
    case DRAFT = 'draft';
    case ON_SALE = 'on_sale';
    case CLOSED = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::DRAFT => 'Draft',
            self::ON_SALE => 'On Sale',
            self::CLOSED => 'Closed',
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
     * All status values as plain strings.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
