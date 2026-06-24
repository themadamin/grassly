<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Redirect user based on their roles to their dashboards
     */
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();
        $role = $user->getRoleNames()->first();

        return match ($role) {
            UserRole::Farmer->value => redirect()->route('farmer.dashboard'),
            UserRole::Merchant->value => redirect()->route('merchant.dashboard'),
            default => abort(403)
        };
    }
}
