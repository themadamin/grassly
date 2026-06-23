<?php

namespace App\Enums;

enum UserRole: string
{
    case Farmer = 'farmer';
    case Merchant = 'merchant';
    case Admin = 'admin';

    /**
     * Roles a user may pick for themselves at registration.
     * Admin is assigned manually, never self-selected.
     *
     * @return array<int, self>
     */
    public static function selfAssignable(): array
    {
        return [self::Farmer, self::Merchant];
    }

    /**
     * All role values as plain strings.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Self-assignable role values as plain strings — the canonical list the
     * registration UI iterates over (shared to the frontend at runtime).
     *
     * @return array<int, string>
     */
    public static function selfAssignableValues(): array
    {
        return array_map(fn (self $role) => $role->value, self::selfAssignable());
    }
}
