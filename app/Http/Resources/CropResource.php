<?php

namespace App\Http\Resources;

use App\Models\Crop;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * A single crop, nested under its category. Matching TS shape:
 * resources/js/types/crop (`Crop`). Needs the `category` relation loaded.
 *
 * @property-read Crop $resource
 */
class CropResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $crop = $this->resource;

        return [
            'id' => $crop->id,
            'name' => $crop->name,
            'slug' => $crop->slug,
            'category' => CategoryResource::make($crop->category),
        ];
    }
}
