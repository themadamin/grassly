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

// Mirrors App\Enums\UserRole. `null` while the visitor is a guest.
export type UserRole = 'farmer' | 'merchant' | 'admin';

export type Auth = {
    user: User;
    role: UserRole | null;
};
