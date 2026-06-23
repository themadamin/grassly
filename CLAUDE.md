# CLAUDE.md — Grassly

Context for Claude Code. Read this first. Keep it in sync as decisions change.

## What this is
A platform linking farmers and merchants. Learning project (not commercial).
Planned features: storage listings, public/private orders, future-harvest
forecasts, delivery tracking, posting/feed, real-time chat.

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

## Design language (Grass.io inspired)
- Lime #A8E63D (primary accent), lime-dark #7AB82A, lime-pale #EBF7CC
- Ink #0F1510 (dark cards/text)
- Stone #F4F5F0 (backgrounds)
- Harvest amber #EF9F27 (seasonal/upcoming info)
- Alert red #E24B4A
- Chunky rounded cards (20px radius), bold uppercase nav, pill badges
- Two-tone cards (lime / ink / stone header variants), subtle topographic texture

## Roadmap (phases)
1. Local env + starter kit            ✅ done
2. Auth & roles (farmer/merchant/admin), profiles, onboarding, dashboards
3. Core marketplace: StorageListing, HarvestForecast, Order (public/private)
4. Transactions & delivery tracking, order lifecycle, notifications
5. Social & comms: real-time chat (Reverb), post feed, comments
6. API & mobile prep: Sanctum tokens, versioned REST endpoints

## Current phase
Phase 2 — Auth & roles.

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