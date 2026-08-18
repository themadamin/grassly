import type { Category } from '@/types/category';

// A single crop, nested under its category — matches App\Http\Resources\CropResource.
export type Crop = {
    id: number;
    name: string;
    slug: string;
    category: Category;
};
