import type { UserRole } from '@/types/enums';

// Public user summary — the farmer/merchant identity nested inside offers and
// products. Matches App\Http\Resources\UserResource.
//
// Distinct from the session user in `@/types/auth` (that one carries
// email_verified_at + timestamps for the logged-in visitor). This is the lean
// "who owns this" shape the API nests in other payloads.
export type User = {
    id: number;
    name: string;
    email: string;
    role: UserRole | null;
    avatar: string | null;
};
