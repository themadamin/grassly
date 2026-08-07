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
- `resources/js/` → `components/` (PascalCase), `components/ui/` (shadcn-vue),
  `composables/`, `layouts/`, `lib/`, `pages/`, `types/`
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
  `resources/js/types/enums/`. **No codegen** — `types:check` is just `vue-tsc`. **Input** =
  FormRequest; `authorize()` returns `true`, authz lives in policies + route middleware.
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
- **Product** — a farmer's item (e.g. Tomato), in the **Storage** section. Lightweight
  umbrella (name/crop, region, notes); NO stock accounting — transactable quantity lives on
  the Offer. `hasMany` offers.
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
- **products** — `user_id` (farmer), `name`/crop, `region`, `notes`, timestamps, softDeletes. `hasMany` offers.
- **offers** — `product_id` FK, `user_id` (farmer, denormalized), `total_quantity`,
  `remaining_quantity`, `unit`, `price` (minor units), `region`, `available_from`/`available_to`,
  `description`, `visibility` (public/private), `status` (draft/on_sale/closed), softDeletes. `hasMany` orders.
- **orders** (Phase 4) — `offer_id` FK, `user_id` (merchant), `quantity`, `price` (snapshot),
  `status` (placed → accepted → packing → in_transit → delivered, + cancelled), `note`.
- **demands** (Phase 4) — merchant buy-offers; mirror of offers.
- **harvest_forecasts** — `user_id`, `crop`, `expected_yield` (base unit), `yield_unit`,
  `expected_from`/`expected_to`, `region`, `notes`, `status` (upcoming/harvested/cancelled).
- **threads/messages** (Phase 5).

Relationships: `Product belongsTo User (farmer)`, `Product hasMany Offer`, `Offer belongsTo
Product`, `Offer hasMany Order`, `Order belongsTo Offer`, `Order belongsTo User (merchant)`,
`User hasMany HarvestForecast`.

Enums: `UserRole`, `OfferStatus`, `OfferVisibility`, `Currency` (plus `ForecastStatus`,
`OrderStatus` when those features land).

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