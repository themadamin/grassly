<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Create the application's roles (farmer / merchant / admin).
     */
    public function run(): void
    {
        // Make sure spatie's cached roles/permissions are flushed first.
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (UserRole::cases() as $role) {
            // findOrCreate is idempotent, so this seeder is safe to re-run.
            Role::findOrCreate($role->value);
        }
    }
}
