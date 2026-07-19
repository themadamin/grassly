<?php

namespace App\Data;

use App\Enums\UserRole;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

/**
 * Type-only DTO: the `App.Data.UserData` shape (used nested as `farmer`).
 * Payload is built by App\Http\Resources\UserResource — keep in sync.
 *
 * Deliberately an explicit allow-list of display-safe fields: NEVER add
 * password, remember_token, or other auth internals. `role` is a string-literal
 * union (App.Enums.UserRole); it isn't a users column (spatie pivot tables), so
 * UserResource resolves it via getRoleNames().
 */
#[TypeScript]
class UserData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?UserRole $role,
        // No avatar column yet (auth.ts already declares `avatar?`).
        public ?string $avatar = null,
    ) {}
}
