<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * A crop's top-level taxonomy category. Matching TS shape:
 * resources/js/types/category (`Category`).
 *
 * @property-read Category $resource
 */
class CategoryResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $category = $this->resource;

        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
        ];
    }
}
