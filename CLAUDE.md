# CLAUDE.md — Grassly

Context for Claude Code. Read this first. Keep it in sync as decisions change.
This file is the always-loaded essentials; deeper guides live in `docs/` — `coding-rules.md`
(how code is written) and `working-agreement.md` (who writes what). Progress lives in
`docs/phase3-todos.md` (not duplicated here).

## What this is
A platform linking farmers and merchants. Learning project (not commercial).
A two-sided Market: farmers post **sell Offers** on their stored **Products**; merchants
post **buy Demands** and place **order claims** (partial fulfilment) against offers. Plus
harvest forecasts, delivery tracking, a community feed, and real-time chat. Full
vocabulary in **Domain model** below.

The developer is new to TypeScript (from JS) and has never shipped an app — explain
TS-specific things briefly when they come up. **Working agreement:** Claude Code scaffolds
+ teaches; the developer writes the logic (frontend AND backend). Stub their learning
  surface with `// TODO(you)` + concept hints; don't fill it in unless asked. Full version:
  `docs/working-agreement.md`.

## Tech stack
- Laravel 13, Vue starter kit (Inertia 3, Vue 3 Composition API, TypeScript)
- Laravel Fortify (auth; headless, UI in app) · spatie/laravel-permission (roles)
- Inertia.js with SSR enabled
- Tailwind v4 + shadcn-vue (UI primitives in `resources/js/components/ui`)
- Laravel Sail (Docker), MySQL, Redis
- Laravel Reverb — real-time (Phase 5) · Laravel Sanctum — API tokens (Phase 7)
- Tooling configured: ESLint, Prettier, Pint, PHPStan

## Roles
farmer / merchant / admin via **spatie/laravel-permission** (roles in the package's
tables, NOT a users column).
- `App\Enums\UserRole` (backed string enum) is the single source of truth; seeded by
  `RoleSeeder` (idempotent, from `DatabaseSeeder`).
- Assigned at registration in Fortify's `CreateNewUser` (`$user->assignRole(...)`). Only
  farmer/merchant self-selectable (`UserRole::selfAssignable()`); admin manual.
- **"Guest" is not a role** — it's the unauthenticated state (`auth.user === null`, type
  `UserRole | null`). Never add a guest enum case.
- Role *values* pass to the frontend as Inertia props; the TS `UserRole` union in
  `resources/js/types/auth.ts` is a hand-maintained mirror — keep it in sync.

## Project structure
- `resources/js/` → `components/` (PascalCase; app-specific components grouped by model
  like `types/` — `components/order/`, `components/nav/`, `components/shared/` for
  cross-model), `components/ui/` (shadcn-vue), `composables/`, `layouts/`, `lib/`,
  `pages/`, `types/`
- App shell: sidebar layout `resources/js/layouts/AppLayout.vue`
- Fortify actions: `app/Actions/Fortify/` (CreateNewUser, ResetUserPassword, PasswordValidationRules)
- Public landing page: standalone layout (no app shell), replaces the starter kit `welcome`

## Coding rules (headlines — full set in `docs/coding-rules.md`)
- Controllers: resourceful, one per model.
- Vue: PascalCase; SFC order `<template>` → `<script setup lang="ts">` → `<style>`; typed
  props (`defineProps<T>()`); TypeScript everywhere on the frontend.
- **Money** = integer minor units via `App\Casts\MoneyCast` (+ `App\Enums\Currency`);
  **quantity** = integer base unit; **never** FLOAT. Formatting lives in PHP.
- **Enums** = string column + PHP backed enum cast (the `UserRole` pattern).
- **Output** = API Resources (`app/Http/Resources`); frontend types are **hand-written per
  model** in `resources/js/types/<model>/` (mirror the Resource, imported as
  `import type { Offer } from '@/types/offer'`). Enums are hand-written unions in
  `resources/js/types/enums/`. **No codegen for model/enum types** — hand-written; the
  one exception is filter DTOs (see Filtering). **Input** =
  FormRequest; `authorize()` returns `true`, authz lives in policies + route middleware.
- **Filtering** = reusable `Illuminate\Pipeline` engine. Per surface: input validated +
  allow-listed by an `Index{Model}Request`, normalized into a `#[TypeScript]`
  `{Model}FilterData` DTO (`app/Data/Filters/`) + a `{Model}SortOption` backed enum, one
  pipe class per filter in `app/Filters/{Model}/` (extend `AbstractFilterPipe`), assembled by
  `Apply{Model}sFilter`. **Fixed order: base scope → filters → sort → paginate.** Filters only
  *narrow*; the base scope (e.g. `Offer::whereOwnedBy`) is applied in the controller before the
  pipeline and is NOT user-overridable. Unknown keys / unlisted sorts are rejected (422), never
  applied. DTOs generate to `resources/js/types/generated.d.ts` as `App.Data.Filters.*` /
  `App.Enums.*` via `php artisan typescript:transform`; frontend filter state mirrors the DTO.
  Reference impls: Offer, Market. (`types:check` = `vue-tsc` — the generated `.d.ts` is committed.)
- Soft deletes on products/offers. Run Pint + PHPStan; keep SSR working (`composer dev:ssr`).

## Design language (Grass.io inspired)
- Lime #A8E63D (accent), lime-dark #7AB82A, lime-pale #EBF7CC
- Ink #0F1510 (dark cards/text) · Stone #F4F5F0 (background)
- Harvest amber #EF9F27 (seasonal/upcoming) · Alert red #E24B4A
- Chunky rounded cards (20px), bold uppercase nav, pill badges
- Two-tone cards (lime / ink / stone header variants), subtle topographic texture
- Sidebar app shell, role-aware nav. Visual design originates in Claude Design, handed off
  to Claude Code for Inertia/Vue implementation.

## Roadmap
1. Local env + starter kit ✅
2. Auth & roles + dashboards + routing ✅
3. Core marketplace — POST + BROWSE: Product/Storage + Offer + harvest forecasts + Market
   browse. NOT orders/Demand (Phase 4).
4. Transactions: orders/claims vs offers, partial fulfilment, delivery tracking,
   notifications; Demand (buy side)
5. Social: per-order chat (Reverb), feed, comments
6. Testing: Pest/PHPUnit, factories, feature tests, CI
7. API & mobile: Sanctum tokens, versioned REST

## Domain model (code + UI use these words)
Two-sided marketplace: farmers post **sell Offers**, merchants post **buy Demands**, both
browse one **Market** (segmented Selling / Buying / All; role-aware default — farmers land
on Buying, merchants on Selling; green "SELLING" / amber "BUYING" badges). "Posting to
market" = publishing an offer (status change), not a separate posts table. Only PUBLIC
offers appear on the Market.

3-layer model + a mirror:
- **Product** — a farmer's item, in the **Storage** section. Lightweight umbrella (`name` —
  the farmer's own free-text label, e.g. "Pink Tomato — Netherlands" — plus `crop_id`,
  notes); NO stock accounting — transactable quantity lives on the Offer. `hasMany`
  offers, `belongsTo` Crop. No region of its own — delivery zones live on the Offer (below).
- **Crop taxonomy (Category → Crop)** — a seeded, **closed list** (farmers pick a crop, no
  free-typing new ones). `Category hasMany Crop`, `Crop belongsTo Category`, `Crop hasMany
  Product`. What stops the Market's crop filter from being a giant unusable dropdown — filter
  by a handful of categories, or search/typeahead (`GET /crops?category=&q=`) for one exact
  crop. Seeded by `CategorySeeder`/`CropSeeder` (idempotent, ~10 categories / ~75 crops,
  FAO/USDA-based), wired into `DatabaseSeeder`.
- **Offer** — a farmer's sell campaign for a product (renamed `StorageListing`). Fixed
  price, `total_quantity` + `remaining_quantity`, status. `belongsTo` product, `hasMany` orders.
- **Order** (a "claim", Phase 4) — a merchant buying PART of an offer; decrements the
  offer's remaining quantity. Own quantity + delivery status.
- **Demand** (Phase 4) — merchant buy-offer, the Offer mirror.
- **Harvest forecast** — informational future supply (a "future offer"), not transactable. Separate.
- **Thread** (Phase 5) — a per-order conversation.

**Claim model:** offers are **fixed price → instant claim**. A merchant takes e.g. 300kg,
`remaining_quantity` decrements immediately — no farmer approval, no pending state.
`Order.status` is a delivery lifecycle (placed → … → delivered, + cancelled).
Negotiation/approval is a later enhancement. Per-order chat handles coordination.

### Entities & relationships
- **categories** — `name`, `slug` (both unique), timestamps. `hasMany` crops. Closed list, seeded.
- **crops** — `category_id` FK, `name`, `slug` (unique), timestamps. `belongsTo` category,
  `hasMany` products. Closed list, seeded.
- **regions** — `name`, `slug` (both unique), timestamps. `belongsToMany` offers (via the
  `offer_region` pivot). Closed list, seeded (`RegionSeeder`, Uzbekistan's 12 regions +
  Karakalpakstan + Tashkent city). An order/delivery zone, not where the crop grows.
- **products** — `user_id` (farmer), `name` (farmer's own label), `crop_id` FK, `notes`,
  timestamps, softDeletes. `hasMany` offers, `belongsTo` crop. No region — a product isn't
  tied to a delivery zone; its offers are.
- **offers** — `product_id` FK, `user_id` (farmer, denormalized), `total_quantity`,
  `remaining_quantity`, `unit`, `price` (minor units), `available_from`/`available_to`,
  `description`, `visibility` (public/private), `status` (draft/on_sale/closed), softDeletes.
  `hasMany` orders, `belongsToMany` regions (via `offer_region` pivot — an offer's
  deliverable zones; can be more than one).
- **orders** (Phase 4) — `offer_id` FK, `user_id` (merchant), `quantity`, `price` (snapshot),
  `status` (placed → accepted → packing → in_transit → delivered, + cancelled), `note`.
- **demands** (Phase 4) — merchant buy-offers; mirror of offers. Still free-text `region`
  (Phase 4 scaffold, out of scope for the region taxonomy migration).
- **harvest_forecasts** — `user_id`, `crop`, `expected_yield` (base unit), `yield_unit`,
  `expected_from`/`expected_to`, `region`, `notes`, `status` (upcoming/harvested/cancelled).
- **threads/messages** (Phase 5).

Relationships: `Category hasMany Crop`, `Crop belongsTo Category`, `Crop hasMany Product`,
`Product belongsTo Crop`, `Product belongsTo User (farmer)`, `Product hasMany Offer`, `Offer
belongsTo Product`, `Offer belongsToMany Region` (deliverable zones, `offer_region` pivot),
`Region belongsToMany Offer`, `Offer hasMany Order`, `Order belongsTo Offer`, `Order
belongsTo User (merchant)`, `User hasMany HarvestForecast`.

Enums: `UserRole`, `OfferStatus`, `OfferVisibility`, `Currency`, `OfferSortOption`,
`MarketSortOption`, `MarketTab` (plus `ForecastStatus`, `OrderStatus` when those features land).

**Nav (role-aware):** Storage (farmers → Products), Offer/Demand (one slot: Offers for
farmers, Demand for merchants), Orders (farmer: incoming claims; merchant: placed claims),
Market (shared browse). Offer creation lives in the Offers section; Product pages have a
shortcut button opening that SAME form pre-filled with `product_id`. No Storage item for merchants.

## Dashboards & routing
- Separate dashboard route per role: `/farmer/dashboard`, `/merchant/dashboard`.
- `/dashboard` is an invokable redirect dispatcher → role-guarded routes via spatie `role:`
  middleware. Role middleware does the post-login redirect.

## Current phase
Phase 3 — Core marketplace (post + browse). **Progress lives in `docs/phase3-todos.md`**
(single source of truth). Phase 4 outline: `docs/phase4-todos.md`.
- **Known Phase-3 simplifications:** quantity stored as a plain int in `unit` (not
  base-unit-kg + tonne conversion); `remaining_quantity` resets to `total_quantity` on
  offer update until Phase 4 orders decrement it.
- **Region taxonomy (2026-08-18):** Product has no region at all — it was removed (column,
  model relation, requests, resources, forms). An Offer's region is now its **deliverable
  zones**: `regions` (closed list, `RegionSeeder`, Uzbekistan's 14 regions/republic/city) is
  `belongsToMany` on Offer via the `offer_region` pivot, replacing the old single
  `offers.region_id` FK. Offer create/edit forms use a multi-select chip picker
  (`region_ids: number[]`, at least one required); `OfferResource`/`OfferListItemResource`
  expose `regions: RegionResource[]`. `MarketFilterData`/`OfferFilterData`'s `region` filter
  field stays a single `int` (unchanged) — it matches offers whose deliverable zones include
  that region (`FilterByRegion` in both `app/Filters/Offers` and `app/Filters/Market` now do
  a real `whereHas('regions', ...)`, no longer TODO stubs). The Market filter panel's actual
  server round-trip (`applyFilters`/`setTab`/`removeFilter` in `market/Index.vue`) is still a
  separate, pre-existing TODO(you) — filter chips stage locally, but nothing yet visits the
  server on Apply.
- **Parked:** profiles / onboarding (early Phase 3); sidebar `isActive()` nav highlighting
  (wire once Market routes exist).

## Commands
- Start: `./vendor/bin/sail up -d`
- Dev: `composer dev` (or `composer dev:ssr` for SSR)
- Lint: `./vendor/bin/pint` (PHP), `npm run lint` (JS/Vue)
- Test: `./vendor/bin/sail artisan test`

## Workflow
Planning/design happens in the Claude.ai project chat; build/fix in Claude Code. When a
structural decision is made in chat, reflect it here so both sides stay in sync.