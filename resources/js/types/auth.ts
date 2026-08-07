// `UserRole` is defined once in `@/types/enums` (mirrors App\Enums\UserRole);
// imported for `Auth` below and re-exported so existing `@/types/auth` imports
// keep working. `null` while the visitor is a guest.
import type { UserRole } from '@/types/enums';

export type { UserRole };

export type User = {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    [key: string]: unknown;
};

export type Auth = {
    user: User;
    role: UserRole | null;
};
