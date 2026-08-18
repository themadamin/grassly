# Phase 3 — Build checklist (ordered, do top to bottom)

This is the **action-by-action** order for Phase 3. Work straight down each
feature. Every feature is split into **milestones** — at the end of each
milestone you can *see a result* (👀 backend = visible in DB/tinker/route;
👀 frontend = visible in the browser). Don't skip ahead; finish a milestone,
see the result, then move on.

**Owner key:**
- 🧑 **YOU** write it (your learning surface).
- 🤖 **CLAUDE CODE** scaffolds/styles it (ask me — I hand back stubs + hints).

Backend always comes before frontend.

> **Phase 3 = POST + BROWSE only.** Products, Offers (sell campaigns), harvest
> forecasts, a crop taxonomy, and a Market to browse them. **No transactions.**
> Orders/claims, partial fulfilment, and the merchant `Demand` (buy-offer) are
> **Phase 4** — see `docs/phase4-todos.md`. See CLAUDE.md → **Domain model** for
> the vocabulary and **Coding rules** for the money/quantity rules.

---

# FEATURE 0 — Refactor + money cast (prerequisites, do these first)

You already scaffolded `StorageListing`. The new model renames it and adds a
lightweight `Product` umbrella above it. Do this now, while only the backend
exists and there's no real data to migrate.

## Milestone 0.1 — The Money cast (👀 backend: one place owns ÷100)
Goal: money is stored as integer **minor units**; the ÷100 lives in one cast.

1. 🤖 Scaffold an empty `app/Casts/Money.php` implementing `CastsAttributes`.
2. 🧑 Fill in `get()` (DB integer cents → display value) and `set()` (input →
   integer cents). Build this **before** any UI touches money.
   *Concept: custom Eloquent casts run at the model boundary — every read/write
   of the attribute passes through them, so conversion never leaks into
   controllers or Blade/Vue.*
3. 🧑 **See it:** unit-check in tinker — set a price, confirm the DB column holds
   an integer and the model returns the display value. 👀

## Milestone 0.2 — Rename StorageListing → Offer (👀 backend)
Goal: the sell campaign is called `Offer` everywhere.

4. 🧑 Rename the model, migration, factory, seeder, policy, controller, enum
   (`ListingStatus` → keep as the offer status: `Draft`/`OnSale`/`Closed`), and
   the `storage-listings` routes/pages to `Offer` / `offers`. 🤖 I'll list every
   file + reference to touch; you make the edits so you see how the pieces wire
   together.
5. 🧑 Update the `offers` migration columns to the new shape (see Feature 2).
   *Concept: because there's no production data yet, prefer editing the existing
   migration over stacking a new one — keep migrations readable.*

✅ **Feature 0 done** when the money cast exists and everything reads `Offer`.

---

# FEATURE 1 — Product (the Storage umbrella — small, build it first)

`Offer belongsTo Product`, so Product must exist first. Product is a
**grouping only** — name/crop, region, notes. NO stock accounting (the
transactable quantity lives on the Offer).

## Milestone 1.1 — Data layer (👀 backend: rows in the DB)
1. 🤖 Scaffold: `artisan make:model Product -mfs`, policy, resource controller.
2. 🧑 Migration `products`: `user_id` FK (farmer, `constrained()->cascadeOnDelete()`),
   `name` (crop), `region` (string), `notes` (text, nullable), `timestamps`,
   **`softDeletes()`**.
   *Concept: soft deletes keep a "deleted" row so anything that referenced it
   isn't vaporized.*
3. 🧑 Model: `$fillable`, `SoftDeletes` trait, `farmer()`
   (`belongsTo(User::class, 'user_id')`) and `offers()` (`hasMany(Offer::class)`).
   Factory.
4. 🧑 **See it:** `Product::factory()->create(['user_id' => 1])` in tinker. 👀

## Milestone 1.2 — Storage section: browse + create (👀 frontend)
5. 🧑 `index` (a farmer's own products), `create`, `store` actions.
6. 🧑 Routes: `Route::resource('products', ProductController::class)`, writes
   behind `['auth', 'role:farmer']`.
7. 🤖 Storage index + create-product page `<template>` (design tokens).
8. 🧑 `<script setup>`: typed props, typed `useForm`, `form.post`.
9. 🧑 **See it:** create a product, see it in your Storage list. 👀

## Milestone 1.3 — Product detail + edit/delete (👀 frontend)
10. 🧑 `show` (product + its offers, order history is Phase 4), `edit`,
    `update`, `destroy`; `ProductPolicy` owner check + `authorize()`.
11. 🤖 Product detail page `<template>`: header, notes, an **open-offers list**,
    and a **"New offer for this product"** shortcut button (opens the Offer
    create form pre-filled with this `product_id`).
12. 🧑 `<script setup>`: typed props; wire the shortcut link to the offer create
    route with `product_id` as a query param / route param.
13. 🧑 **See it:** open a product, edit it, use the shortcut button. 👀

✅ **Feature 1 done** when a farmer manages their own products and a product
detail page links into the offer create form.

---

# FEATURE 2 — Offer (the sell campaign — the template, build it fully, slowly)

The renamed `StorageListing`. Fixed price, divisible quantity: `total_quantity`
fixed at creation, `remaining_quantity` decremented later by claims (Phase 4).

## Milestone 2.1 — Data layer (👀 backend)
1. 🧑 `OfferStatus` backed enum: `Draft` / `OnSale` / `Closed`. Mirror the
   `UserRole` pattern. Add an `OfferVisibility` enum: `Public` / `Private`.
2. 🧑 Migration `offers`:
   - `product_id` FK (`constrained()->cascadeOnDelete()`)
   - `user_id` FK (farmer, **denormalized** so you can scope offers without
     joining through products)
   - `total_quantity` (unsigned integer, **base unit = grams/kg**)
   - `remaining_quantity` (unsigned integer, defaults to `total_quantity`)
   - `unit` (string label, e.g. `kg`)
   - `price` (unsigned **integer, minor units** — cast with your `Money` cast)
   - `region` (string)
   - `available_from` (date), `available_to` (date, nullable)
   - `description` (text, nullable)
   - `visibility` (string, default `public`)
   - `status` (string, default `draft`)
   - `timestamps`, **`softDeletes()`**
   *Concept: never FLOAT for money/quantity — integers only (CLAUDE.md → Data
   storage practices).*
3. 🧑 Model: `$fillable`, `SoftDeletes`, `casts()` (dates → `date`, `status` →
   `OfferStatus::class`, `visibility` → `OfferVisibility::class`, `price` →
   `Money::class`), `product()` + `farmer()` + `orders()` relations. Factory
   (seed `remaining_quantity = total_quantity`).
4. 🧑 **See it:** create an offer in tinker; confirm the casts (enum, Carbon
   dates, money display) and that `remaining_quantity` starts full. 👀

## Milestone 2.2 — Create an offer from the UI (👀 frontend)
5. 🧑 `create` (accepts an optional `product_id` to pre-select the product) +
   `store` (validate → set `user_id`, `remaining_quantity = total_quantity` →
   save → redirect). Validate inline or with a FormRequest.
6. 🧑 Routes: `Route::resource('offers', OfferController::class)`, writes behind
   `['auth', 'role:farmer']`, reads open to any authed user.
7. 🤖 Create-offer page `<template>` + Tailwind (shadcn-vue inputs, design
   tokens). A product `<select>` (pre-selected when `product_id` is passed),
   quantity + unit, price. I wire `@submit`, `v-model` to stubbed refs.
8. 🧑 `<script setup>`: a TS interface for the form shape, a typed `useForm<T>()`,
   `form.post(route('offers.store'))` with error handling.
   *Concept: `defineProps<T>()`, Inertia `useForm`, typed forms.*
9. 🧑 **See it:** create an offer, both from `/offers/create` and from the
   product-page shortcut. 👀

## Milestone 2.3 — Browse + view offers (👀 frontend)
10. 🧑 `index` (`Offer::with(['product','farmer'])->latest()->paginate()`) +
    `show` (route-model binding, eager load).
    *Concept: route model binding, eager loading to avoid N+1.*
11. 🤖 Offers index (card grid) + detail `<template>`. Detail shows the offer
    summary + a **progress bar** (`remaining_quantity` / `total_quantity`) — the
    incoming-claims list is Phase 4.
12. 🧑 `<script setup>` for both (type the paginated prop + single-offer prop).
    *Concept: typing Inertia props, pagination shape.*
13. 🧑 **See it:** browse offers, open one, see its progress bar. 👀

## Milestone 2.4 — Edit, update, delete (👀 frontend: owner-only)
14. 🧑 `OfferPolicy` `update` + `delete` (`$offer->user_id === $user->id`);
    `edit`/`update`/`destroy` with `authorize()`.
15. 🤖 Edit page `<template>` (reuse the create layout).
16. 🧑 Edit `<script setup>`: pre-fill `useForm` from the offer prop,
    `form.put(...)`; delete button → `router.delete(...)`.
17. 🧑 **See it:** edit your own offer, get 403 on someone else's, delete one. 👀

## Milestone 2.5 — Polish
18. 🧑 Filters on `index` (crop via product, region, status) from
    `request()->query()`, applied with `when()`.
19. 🤖 Filter controls; 🧑 wire a debounced `router.get(..., { only: [...] })`
    partial reload.
20. 🤖 Run Pint + PHPStan; 🧑 fix any issues in your code.

✅ **Feature 2 done** when a farmer creates/edits/deletes their own offers,
anyone can browse + filter + view detail (with progress bar), and tooling is
clean.

---

# FEATURE 3 — HarvestForecast (practice — same recipe, go faster)

> Informational future supply (a "future offer") — NOT transactable. Same loop
> as Offer; try each step before asking.

## Milestone 3.1 — Data layer (👀 backend)
1. 🤖 Scaffold: `make:model HarvestForecast -mfs`, policy, resource controller.
2. 🧑 `ForecastStatus` enum: `Upcoming` / `Harvested` / `Cancelled`.
3. 🧑 Migration `harvest_forecasts`: `user_id` FK (farmer, cascade), `crop`
   (string), `expected_yield` (unsigned integer, **base unit**), `yield_unit`
   (string), `expected_from` + `expected_to` (dates — the harvest window),
   `region` (string), `notes` (text, nullable), `status` (string, default
   `upcoming`), `timestamps`.
4. 🧑 Model: `$fillable`, `casts()` (dates + `ForecastStatus`), `farmer()`.
   Factory. **See it** in tinker. 👀

## Milestone 3.2 — Create from UI (👀 frontend)
5. 🧑 `create` + `store`. Routes: `Route::resource('harvest-forecasts', ...)`,
   writes behind `['auth','role:farmer']`, reads open.
6. 🤖 Create-forecast page `<template>` (ink-header variant + amber "upcoming"
   pill from the design language).
7. 🧑 `<script setup>`: typed `useForm`, `form.post`. **See it.** 👀

## Milestone 3.3 — Browse + detail (👀 frontend)
8. 🧑 `index` + `show`. 🤖 Index grid + detail `<template>`. 🧑 `<script setup>`
   for both (typed props). **See it.** 👀

## Milestone 3.4 — Edit / update / delete (👀 frontend)
9. 🧑 Policy (owner check) + `edit`/`update`/`destroy` + `authorize()`.
10. 🤖 Edit page `<template>`. 🧑 Edit `<script setup>`. **See it** (owner edits,
    others 403). 👀
11. 🤖 Pint + PHPStan; 🧑 fix your code.

✅ **Feature 3 done** — same definition of done as Feature 2, for forecasts.

---

# FEATURE 3.5 — Crop taxonomy (categories + crops), CLOSED list

> Prerequisite for good Market filtering. Replaces the free-text crop on Product
> with a normalized two-level taxonomy: **Category → Crop**. Seeded, closed
> (farmers pick a seeded crop; no free-typing). This is what stops the crop
> filter from being a giant unusable dropdown. Full handoff:
> `market-filter-backend-prompt.md`.

## Milestone 3.5.1 — Taxonomy tables + seed (👀 backend: rows in DB)
1. 🤖 Scaffold `make:model Category -ms`, `make:model Crop -ms`.
2. 🧑 Migrations: `categories` (`name` unique, `slug` unique); `crops`
   (`category_id` FK cascade, `name`, `slug` unique).
   *Concept: two-level lookup taxonomy — Category hasMany Crop.*
3. 🧑 Models + relations (`Category hasMany Crop`; `Crop belongsTo Category`,
   `Crop hasMany Product`).
4. 🤖 Seeders: ~10 categories + a solid starter crop list per category
   (FAO/USDA-based), idempotent (`updateOrCreate` on slug), wired into
   `DatabaseSeeder`. (Reference data — Claude writes, you review.)
5. 🧑 **See it:** seed, confirm categories + crops in the DB. 👀

## Milestone 3.5.2 — Refactor Product → crop_id (👀 backend)
6. 🧑 Migration: replace free-text crop on `products` with `crop_id` FK (edit the
   existing products migration — no real data yet).
   *Concept: normalizing a string into an FK so everyone's "tomato" matches.*
7. 🧑 Product model: `crop()` `belongsTo(Crop)`; category via `crop->category`.
8. 🧑 Validation: `crop_id` required + `Rule::exists('crops','id')`.
9. 🧑 Update `ProductData`/`ProductResource` (+ offer ones) to expose crop +
   category; regenerate TS types.
10. 🧑 **See it:** create a product picking a seeded crop; crop + category resolve. 👀

## Milestone 3.5.3 — Crop search endpoint (👀 backend: JSON)
11. 🤖 Scaffold `GET /crops` → `CropController@index`.
12. 🧑 Query: filter by `category` (optional) + `q` (partial name match), capped
    list of id+name. *Concept: a JSON endpoint the typeahead hits as you type —
    keeps the full crop list off the client.*
13. 🧑 **See it:** `/crops?category=vegetables&q=tom` returns Tomato. 👀

✅ **Feature 3.5 done** when Product references a seeded Crop, the category/crop
relationship resolves, and the crop-search endpoint returns scoped matches.

---

# FEATURE 4 — Market / Browse + search (do last — needs data to browse)

> The shared browse experience. Phase 3 surfaces **Offers** (sell campaigns);
> when `Demand` is built (Phase 4) the Market gains the Buying tab. Use
> **segmented tabs** (Selling / Buying / All) — simpler queries, clearer UX.

## Milestone 4.1 — The browse page (👀 frontend)
1. 🧑 A `MarketController` (invokable) returning offers for the active tab
   (reuse the Offer index query; only PUBLIC offers via a visibility scope).
   In Phase 3 only the Selling tab has data.
2. 🤖 Market page `<template>` with segmented tabs + card grid (reuse the offer
   card component). Green "SELLING" badge now; amber "BUYING" reserved for
   Phase 4 demands. **Role-aware default:** farmers default to Buying (empty for
   now), merchants to Selling.
3. 🧑 `<script setup>`: typed props per tab, tab state.
4. 🧑 **See it:** one page browsing public offers. 👀

## Milestone 4.2 — Filter toolbar + server-driven search/filter/sort (👀 frontend)
> The three tabs (Selling/Buying/All) stay as-is. Below them: a one-line toolbar
> — `[ search ] [ filter icon ] [ sort ] [ Apply ]`. The filter icon opens a
> panel (desktop popover / mobile bottom sheet) with: category chips, a
> category-scoped crop typeahead, region, availability, date range, price range.
> Selections STAGE inside the panel; the toolbar **Apply** commits everything in
> one request. Design: `market-filter-design-prompt.md`. Backend:
> `market-filter-backend-prompt.md` (Part D).

5. 🧑 `MarketController` reads all filter state from `request()->query()`:
   `search`, `category`, `crop`, `region`, `availability`, `date_from`,
   `date_to`, `price_min`, `price_max`, `sort`.
6. 🧑 Apply it with `when()` conditionals or Offer **query scopes**:
   - `search` → partial match on title/description + crop name (`whereHas`).
   - `category` → `whereHas('product.crop', …category_id…)`.
   - `crop` → `whereHas('product', …crop_id…)`.
   - `region`, `availability` (dates bracket today), `date_from`/`date_to`.
   - `price_min`/`price_max` → compare against the **integer minor-unit** column
     (convert incoming major units first).
   - `sort` → newest/oldest/price asc/price desc/quantity. Always PUBLIC only,
     then `paginate()`.
   *Concept: `when()` conditional query building / query scopes; `whereHas` for
   related-model filters; price compared in minor units.*
7. 🤖 Filter toolbar + panel `<template>` (search, filter popover/sheet, sort,
   Apply) matching the design. The crop typeahead calls `GET /crops`.
8. 🧑 `<script setup>`: staged filter state in the panel; on **Apply**, serialize
   to query params and do ONE
   `router.get(route('market'), params, { only: ['offers'], preserveState: true })`
   partial reload. Type the crop-typeahead results.
   *Concept: `router.get`, partial reloads (`only:`), building a query-param
   object from form state.*
9. 🧑 **See it:** set filters + sort, hit Apply, results refetch without a full
   reload; the filter icon shows an active-count badge. 👀
10. 🤖 Pint + PHPStan; 🧑 fix your code.

---

# After all features — update the docs (🤖 ask me)
- CLAUDE.md → **Current phase**: mark Phase 3 features done/in progress; drop the
  "active refactor" note once the rename has landed.
- CLAUDE.md → **Domain model**: confirm it matches the built tables (Product,
  Offer, HarvestForecast) and add the taxonomy — `Category` + `Crop` and the
  `Product belongsTo Crop belongsTo Category` chain; note the **closed-list** decision.
- CLAUDE.md → note the new enums (`OfferStatus`, `OfferVisibility`,
  `ForecastStatus`) next to the `UserRole` enum note.

# Phase 3 — Definition of done
- [ ] `StorageListing` renamed to `Offer`; `Product` umbrella exists; `Money`
      cast in place; money + quantity stored as integers (no floats).
- [ ] Crop taxonomy seeded (Category → Crop, closed list); Product references a
      `crop_id`; crop-search endpoint works.
- [ ] Farmer creates/edits/deletes own products, offers, and harvest forecasts.
- [ ] Offer detail shows a `remaining_quantity` / `total_quantity` progress bar.
- [ ] Market: tabs unchanged; filter toolbar (search + filter panel + sort +
      Apply) drives server-side search/filter/sort; results refetch via partial reload.
- [ ] Pint + PHPStan clean.
