<?php

namespace App\Http\Resources;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * A single region. Matching TS shape: resources/js/types/region (`Region`).
 *
 * @property-read Region $resource
 */
class RegionResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $region = $this->resource;

        return [
            'id' => $region->id,
            'name' => $region->name,
            'slug' => $region->slug,
        ];
    }
}
