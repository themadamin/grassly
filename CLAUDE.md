# CLAUDE.md — Grassly

Context for Claude Code. Read this first. Keep it in sync as decisions change.

## What this is
A platform linking farmers and merchants. Learning project (not commercial).
A two-sided Market: farmers post **sell Offers** on their stored **Products**;
merchants post **buy Demands** and place **order claims** (with partial
fulfilment) against offers. Plus future-harvest forecasts, delivery tracking,
a community feed, and real-time chat. See the Domain model section for the full
vocabulary.

The developer is new to TypeScript (comes from JS) and has never shipped an
app before. When TypeScript-specific things come up, explain them briefly
rather than assuming familiarity.

## Tech stack
- Laravel 13, Vue starter kit (Inertia 3, Vue 3 Composition API, TypeScript)
- Laravel Fortify for authentication (headless; UI lives in the app)
- spatie/laravel-permission for roles & permissions
- Inertia.js with SSR enabled
- Tailwind v4 + shadcn-vue (UI primitives in resources/js/components/ui)
- Laravel Sail (Docker), MySQL, Redis
- Laravel Reverb for real-time (Phase 5, chat)
- Laravel Sanctum for API tokens (Phase 6, mobile)
- Tooling already configured: ESLint, Prettier, Pint, PHPStan (phpstan.neon)

## Roles
farmer / merchant / admin — managed with **spatie/laravel-permission**
(roles live in the package's permission tables, not a users column).
- Role names are centralized in `App\Enums\UserRole` (backed string enum).
- Seeded by `RoleSeeder` (called from `DatabaseSeeder`; idempotent).
- Assigned during registration via the Fortify `CreateNewUser` action with
  `$user->assignRole($input['role'])`. Only farmer/merchant are
  self-selectable (`UserRole::selfAssignable()`); admin is assigned manually.
- **"Guest" is not a role** — it's the unauthenticated state, modelled as
  `auth.user === null` / `auth.role === null` (type `UserRole | null`). Never
  add a guest case to the enum (a guest has no `User` to assign it to).
- **Single source of truth:** `App\Enums\UserRole` is canonical. The role
  *values* are shared to the frontend at runtime (e.g. `UserRole::values()` /
  `selfAssignableValues()` passed as Inertia props) so the UI iterates the
  list instead of hardcoding keys. The TS `UserRole` union in
  `resources/js/types/auth.ts` is a hand-maintained mirror — runtime props
  can't generate a compile-time type, so keep it in sync when the enum changes.

## Project structure notes
- Frontend lives in resources/js/
    - components/    reusable Vue components (PascalCase)
    - components/ui/ shadcn-vue primitives
    - composables/   Vue composables
    - layouts/       app + auth layouts
    - lib/           utilities & config
    - pages/         Inertia page components
    - types/         TypeScript definitions
- App shell: sidebar layout (resources/js/layouts/AppLayout.vue)
- Fortify actions in app/Actions/Fortify/ (CreateNewUser, ResetUserPassword,
  PasswordValidationRules)

## Conventions
- Controllers: resourceful, one per model
- Vue components: PascalCase
- Vue SFC block order: `<template>` first, then `<script setup lang="ts">`
  (and `<style>` last if present)
- Use TypeScript everywhere on the frontend; prefer typed props & defineProps
- Run Pint before committing PHP; ESLint/Prettier for JS/Vue
- Keep Inertia SSR working — test with `composer dev:ssr` when touching layouts

### Type generation (data-shape source of truth)
- Backend DTOs are the single source of truth for data shapes. They live in
  `app/Data`, extend `spatie/laravel-data`'s `Data`, and are annotated
  `#[TypeScript]`.
- `spatie/laravel-typescript-transformer` (v3, configured in
  `App\Providers\TypeScriptTransformerServiceProvider` — the modern service
  provider way, NOT a `config/` file) generates
  `resources/js/types/generated.d.ts`. That file is **gitignored** and rebuilt
  on dev (`vite-plugin-watch` on `app/Data` + `app/Enums`) and on
  build/CI (`npm run build`, `composer transform-types`, or
  `php artisan typescript:transform`).
- Enums emit as **string-literal unions** (`'draft' | 'on_sale' | 'closed'`),
  not native TS `enum`s.
- Consumed on the frontend as `App.Data.*` (and `App.Enums.*`) — a **global
  ambient** namespace, so no `import` is needed. Replace hand-written prop
  interfaces with these generated types.
- One `*Data` DTO per model, plus lean list variants where a list screen
  doesn't need the full shape (e.g. `OfferListItemData` for Market/index).
- DTOs are an explicit **allow-list** — never expose secrets/auth internals.
  Money stays integer minor units + a formatted display string; quantity stays
  integer base unit + a display string (formatting lives in PHP).
- These same DTOs are reused for the Sanctum REST API later (roadmap step 7).

**Input vs output split (current, may change):** laravel-data DTOs are for
**output** (Inertia props / API responses) + generating TS types. **Input
validation uses FormRequest classes** (`app/Http/Requests`), NOT laravel-data's
built-in validation. FormRequest `authorize()` always `return true;` —
authorization lives in **policies + route middleware**, not in requests.

## Design language (Grass.io inspired)
- Lime #A8E63D (primary accent), lime-dark #7AB82A, lime-pale #EBF7CC
- Ink #0F1510 (dark cards/text)
- Stone #F4F5F0 (backgrounds)
- Harvest amber #EF9F27 (seasonal/upcoming info)
- Alert red #E24B4A
- Chunky rounded cards (20px radius), bold uppercase nav, pill badges
- Two-tone cards (lime / ink / stone header variants), subtle topographic texture

## Roadmap (phases)
1. Local env + starter kit                                        ✅ done
2. Auth & roles (farmer/merchant/admin), role dashboards, routing ✅ done
3. Core marketplace — **POST + BROWSE only**
   - Product (Storage section) + Offer (sell campaign per product):
     create/edit/delete/show, owner-only writes
   - Harvest forecasts: create + browse
   - Market: browse Offers with filters (segmented Selling/Buying/All tabs)
   - Profiles / onboarding land here (early)
   - NOT orders/transactions and NOT Demand — both are Phase 4
4. Transactions & fulfillment
   - Orders/claims placed against offers; partial fulfilment
     (`remaining_quantity` decrements)
   - Reusable campaign-detail claims list (serves both roles)
   - Demand (merchant buy-offer, the Offer mirror)
   - Delivery tracking, order lifecycle/status, notifications
   - Optional request+approve flow (only if negotiation is added)
5. Social & comms: per-order chat threads (Reverb), community feed, comments
6. Testing: Pest/PHPUnit, factories, feature tests, CI
7. API & mobile prep: Sanctum tokens, versioned REST endpoints

## Domain model (Phase 3 vocabulary — code + UI use these words)

Two-sided marketplace: farmers post **sell Offers**, merchants post **buy
Demands**, both browse one **Market** (segmented Selling / Buying / All tabs;
role-aware default filter — farmers land on Buying, merchants on Selling). Sell
vs buy must be visually unmistakable (green "SELLING" / amber "BUYING" badges).
"Posting to market" = publishing an offer (a status change), NOT a separate
posts table. Only PUBLIC offers appear on the Market.

3-layer model + a mirror:
- **Product** — a farmer's item (e.g. Tomato), lives in the **Storage** section.
  Lightweight umbrella: name/crop, region, notes, aggregated views. Grouping
  only — NO enforced stock accounting yet (transactable quantity lives on the
  Offer). `hasMany` offers.
- **Offer** — a farmer's sell campaign for a product ("1t of my tomatoes at $X").
  This is what `StorageListing` becomes. Fixed price, `total_quantity` +
  `remaining_quantity`, status. `belongsTo` product, `hasMany` orders.
- **Order** (a "claim") — a merchant buying PART of an offer's quantity;
  decrements the offer's remaining quantity. Own quantity + delivery status.
  **Phase 4.**
- **Demand** — the merchant's buy-offer, the mirror of an Offer ("I want to buy
  X"). Separate entity. **Phase 4.**
- **Harvest forecast** — informational future supply (a "future offer"), not
  immediately transactable. Separate entity.
- **Thread** — a per-order conversation (Phase 5 chat).

**Claim model:** offers are **fixed price** → **instant claim**. A merchant
takes e.g. 300kg, `remaining_quantity` decrements immediately — no farmer
approval, no pending state, no race condition. `Order.status` in Phase 4 is just
placed → … → delivered (+ cancelled); no pending/approved/declined yet.
Negotiation / approval is a later enhancement. Keep a per-order chat so both
sides coordinate logistics after the claim.

### Entities & relationships
- **products** — `user_id` (farmer), `name`/crop, `region`, `notes`, timestamps,
  soft deletes. `hasMany` offers.
- **offers** (renamed `StorageListing`) — `product_id` FK, `user_id` (farmer,
  denormalized for scoping), `total_quantity`, `remaining_quantity`, `unit`,
  `price` (minor units), `region`, `available_from`/`available_to`,
  `description`, `visibility` (public/private), `status`
  (draft/on_sale/closed), soft deletes, timestamps. `hasMany` orders.
- **orders** (claims, Phase 4) — `offer_id` FK, `user_id` (merchant),
  `quantity`, `price` (snapshot at purchase), `status` (placed → accepted →
  packing → in_transit → delivered, + cancelled), `note`. Placing one
  decrements `offers.remaining_quantity`.
- **demands** (Phase 4) — merchant buy-offers; mirror of offers.
- **harvest_forecasts** — `user_id`, `crop`, `expected_yield` (base unit),
  `expected_from`/`expected_to`, `region`, `notes`, `status`
  (upcoming/harvested/cancelled).
- **threads/messages** (Phase 5) — per-order chat.

Relationships: `Product belongsTo User (farmer)`, `Product hasMany Offer`,
`Offer belongsTo Product`, `Offer hasMany Order`, `Order belongsTo Offer`,
`Order belongsTo User (merchant)`, `User hasMany HarvestForecast`.

**Nav (role-aware):** Storage (farmers → their Products), Offer/Demand (one
slot: Offers for farmers, Demand for merchants), Orders (transactions — farmer
sees incoming claims, merchant sees claims placed), Market (shared browse).
Offer creation lives in the Offers section; Product pages have shortcut buttons
that open that SAME form pre-filled with `product_id` (one form, two entry
points). No "Storage" item for merchants.

## Data storage practices
- **Never** store money or quantities in FLOAT/DOUBLE (binary float is inexact).
- **Money:** integer **minor units** (e.g. cents) via a custom Eloquent cast
  that converts at the model boundary (the ÷100 lives in one place). Build the
  cast BEFORE any UI touches money.
- **Quantity / capacity:** integer in a **base unit** (kilograms; grams if
  sub-kg precision is needed); display in tonnes/kg with a unit label.
- **Enums:** string column in DB, cast to a PHP backed enum in the model (same
  pattern as `UserRole`).
- **Soft deletes** on products/offers (and later orders) so a referenced record
  isn't vaporized.
- Region: start as a string column; a `regions` lookup table is a later concern.

## Current phase
Phase 3 — Core marketplace (post + browse). Phase 2 (auth, roles, dashboards)
is ✅ done — GrasslyAppLayout shell + Farmer/Merchant dashboards; `/dashboard`
is an invokable redirect dispatcher → role-guarded `/farmer/dashboard` &
`/merchant/dashboard` via spatie `role:` middleware.

**Features 0–2 done (2026-07-13):** `StorageListing` → **`Offer`** (sell campaign)
with a lightweight **`Product`** umbrella (`Product hasMany Offer`,
`Offer belongsTo Product`, farmer denormalized onto the offer). Offers reshaped to
the domain-model schema: `product_id`, `total_quantity`/`remaining_quantity`,
`unit`, `visibility` (`OfferVisibility` public/private), soft deletes; `title`
kept as a farmer-authored headline. **Money layer:** integer minor units via
`App\Enums\Currency` + `App\Casts\MoneyCast` (store int / read decimal); enums
`OfferStatus` + `OfferVisibility` sit alongside `UserRole`. **Output = Laravel API
Resources** (`app/Http/Resources`) that build the payload and own display
formatting; **`app/Data` DTOs are now type-only** mirrors for TS generation — keep
each Resource/DTO pair in sync. Full owner-scoped Product + Offer CRUD (forms,
progress bar, product picker, `offers_count`).

Two deliberate simplifications vs. the letter of the domain model: quantity is a
plain int in `unit` (kg/ton), not base-unit-kg with tonne conversion; and
`remaining_quantity` is reset to `total_quantity` on update until Phase 4 orders
decrement it.

**Still open in Phase 3:** **HarvestForecast** (Feature 3) and the shared **Market**
browse + server-side filters (Feature 4). See `docs/phase3-todos.md`. No
`direction` field — the buy side is the separate `Demand` entity (Phase 4).

- Profiles / onboarding — deferred into early Phase 3.
- Parked stub: sidebar `isActive()` nav highlighting — wire once Market routes exist.

## Commands
- Start: `./vendor/bin/sail up -d`
- Dev:   `composer dev`  (or `composer dev:ssr` to test SSR)
- Lint:  `./vendor/bin/pint` (PHP), `npm run lint` (JS/Vue)
- Test:  `./vendor/bin/sail artisan test`

## Workflow note
Planning/design happens in the Claude.ai project chat. Build/fix happens here
in Claude Code. When a structural decision is made in chat, reflect it in this
file so both sides stay in sync.

## Layouts
- Public landing page: standalone layout (no app shell). Replaces the
  starter kit `welcome` page.
- Authenticated app: sidebar shell (resources/js/layouts/AppLayout.vue).

## Dashboard routing
- Separate dashboard route per role: `/farmer/dashboard`,
  `/merchant/dashboard` (not one shared `/dashboard` that branches in-page).
- Role-based middleware does the redirect after login, sending each user to
  their role's dashboard.

## Design workflow
- Visual design originates in Claude Design (claude.ai/design), seeded with
  the Grass.io reference + brand tokens, then handed off to Claude Code for
  implementation as Inertia/Vue pages.

## Working agreement (how we build together)

The developer is learning Vue 3, TypeScript, Inertia, **and Laravel/PHP** by
building this app — they want to learn the **backend too**, not just the
frontend. Across the whole stack the rule is the same: Claude scaffolds and
teaches; the developer writes the logic. Do NOT implement their learning
surface for them — stub it, give hints, explain the concept, and hand it back.
Only write a complete solution when the developer explicitly asks.

For Vue single-file components, split the work like this:

**Claude Code owns:**
- `<template>` — HTML structure, semantic markup, accessibility
- Styling — Tailwind v4 classes, the Grassly design tokens, shadcn-vue composition
- Visual layout matching the Claude Design handoff
- Template bindings' SHAPE: write the `@click`, `v-for`, `v-model`, `:prop`
  references, but leave the logic behind them as stubs

**The developer owns (do NOT fill these in — stub and hand back):**
- `<script setup lang="ts">` logic — reactive state (ref/computed), event
  handlers, form logic, Inertia visits (useForm, router), composables
- TypeScript types / interfaces for props, emits, and data shapes
- Any business logic

**How to stub for the developer:**
- Declare the variables/functions the template needs, but leave bodies empty
  with a `// TODO(you): ...` comment explaining what it should do and a hint
  about the Vue/Inertia/TS concept involved.
- Example:
  ```ts
  // TODO(you): create a typed useForm for the listing fields below.
  // Hint: Inertia's useForm<T>() — define an interface for the form shape first.
  const form = /* TODO */;

  // TODO(you): POST to the store route on submit, handle validation errors.
  // Hint: form.post(route('listings.store'), { ... })
  function handleSubmit() { /* TODO */ }
  ```
- When a TypeScript concept comes up (generics, interfaces, type narrowing,
  defineProps<T>()), add a 1–2 line plain explanation in a comment, since the
  developer is new to TS.

**Backend (PHP / Laravel) — same split:**
- Claude owns: class/file scaffolding (controller/model/migration/request
  skeletons, route SHAPE), boilerplate, and running tooling (Pint, PHPStan,
  tests).
- The developer owns + is learning: controller actions, model logic, validation
  rules, Eloquent queries, Fortify actions, enum methods, policies — the
  business logic. Stub method bodies with `// TODO(you): ...` plus a hint
  naming the Laravel concept (e.g. "Rule::enum()", "Eloquent relationship",
  "form request authorize()"), and explain it — don't fill it in.
- When a Laravel/PHP concept comes up (facades, service container, Eloquent
  relations, middleware, enums, events), add a 1–2 line plain explanation.

**When the developer asks for help with their part:**
- Explain the concept and guide them; show small examples. Don't just write the
  whole solution unless they explicitly ask for it — the code is their
  learning surface, frontend and backend alike.

**Build order:** follow the phase roadmap. Build a screen only when its phase
arrives; the designs for all screens already exist (Claude Design).