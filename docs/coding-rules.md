# Coding rules — how code is written

How code should look in this repo, regardless of who writes it. (For *who* writes what —
the learning split between developer and Claude Code — see `docs/working-agreement.md`.)
CLAUDE.md carries the headline list; this is the full set.

## Controllers
- Resourceful, one per model.

## Vue components
- PascalCase names.
- SFC block order: `<template>` → `<script setup lang="ts">` → `<style>` (if present).
- Typed props; prefer `defineProps<T>()`.
- TypeScript everywhere on the frontend.

## Data shapes & output
- **Output:** API Resources (`app/Http/Resources`) build the response payload and **own
  display formatting** (money display string, quantity display string, etc.). A Resource is
  the single source of a payload's wire shape.
- **Frontend types are hand-written per model** under `resources/js/types/<model>/index.ts`
  (`offer`, `order`, `demand`, `product`, `user`), each mirroring its Resource. Full shape +
  lean list variant live in the same module (e.g. `Offer` and `OfferListItem`). Consumed
  with real ES-module imports: `import type { OfferListItem } from '@/types/offer'`.
- Keep each Resource/type pair in sync **by hand** — add / rename / remove a field in both
  or the TS type lies. Cross-model refs use `import type` (e.g. `Offer` nests `ProductListItem`
  + `User`).
- These types are an explicit **allow-list** — never expose secrets or auth internals.
- **Enums** are hand-written string-literal unions in `resources/js/types/enums/index.ts`
  (one export per `app/Enums` enum, e.g. `export type OfferStatus = 'draft' | 'on_sale' | 'closed'`).
  Model types import them: `import type { OfferStatus } from '@/types/enums'`. Values MUST
  match the PHP enum `->value`s. `UserRole` is re-exported from `@/types/auth` for back-compat.
- **No codegen.** All frontend types are hand-written — there is no build/CI type-generation
  step. `types:check` is just `vue-tsc --noEmit`.
- History: model shapes were once generated from `app/Data` laravel-data DTOs (`App.Data.*`)
  and enums from `spatie/laravel-typescript-transformer` (`App.Enums.*`, ambient global). Both
  the DTOs and the transformer package were removed; everything is hand-written now.

## Input & validation
- **FormRequest** classes (`app/Http/Requests`) for input validation — NOT laravel-data's
  built-in validation.
- FormRequest `authorize()` always `return true;` — authorization lives in **policies +
  route middleware**, not in requests.

## Data storage
- **Never** FLOAT/DOUBLE for money or quantities (binary float is inexact).
- **Money:** integer **minor units** via `App\Casts\MoneyCast` (+ `App\Enums\Currency`) —
  the ÷100 lives in the cast, at the model boundary. Build the cast before any UI touches money.
- **Quantity / capacity:** integer in a **base unit** (kg; grams if sub-kg precision
  needed); display in tonnes/kg with a unit label.
- **Formatting lives in PHP**, never the frontend — expose a formatted display string.
- **Enums:** string column in DB + PHP backed enum cast (the `UserRole` pattern).
- **Soft deletes** on products / offers (and later orders).
- Region: string column for now; a `regions` lookup table is a later concern.

## Tooling (run before committing)
- **Pint** for PHP formatting; **ESLint / Prettier** for JS/Vue.
- **PHPStan** for static analysis.
- Keep Inertia **SSR** working — test `composer dev:ssr` when touching layouts.