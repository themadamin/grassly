// `import type` pulls in ONLY the type at compile time — it's erased from the
// build, so it never becomes a runtime import. Use it for all cross-module type
// references here.
import type { Crop } from '@/types/crop';
import type { User } from '@/types/user';

// Full product detail — matches App\Http\Resources\ProductResource.
export type Product = {
    id: number;
    user_id: number;
    name: string;
    crop: Crop;
    notes: string | null;
    offers_count: number;
    farmer: User;
};

// Lean product for list/card screens — matches App\Http\Resources\ProductListItemResource.
export type ProductListItem = {
    id: number;
    name: string;
    crop: Crop;
    notes: string | null;
    offers_count: number;
};
