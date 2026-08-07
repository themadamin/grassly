<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Builds the JSON payload for a User (used nested as `farmer`).
 *
 * SINGLE RESPONSIBILITY: model → response array. The matching TypeScript shape
 * lives in resources/js/types/user (`User`) — keep the keys here in sync with it.
 *
 * @property-read User $resource
 */
class UserResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->resource;

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            // Role isn't a users column — it lives in spatie/laravel-permission's
            // pivot tables, so read it here rather than off an attribute.
            'role' => $user->getRoleNames()->first(),
            // No avatar column yet.
            'avatar' => null,
        ];
    }
}
