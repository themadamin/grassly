# Phase 4 — Transactions & fulfilment (outline)

> Moved here from the old Phase 3 checklist. The old "Order = public/private buy
> request + visibility scope" design is **superseded** — an Order is now a
> **claim** a merchant places against an existing Offer. This is an outline;
> finer milestones get filled in when Phase 4 starts (Phase 3 must land first).
> See CLAUDE.md → **Domain model** (claim model) + **Data storage practices**.

**Owner key:** 🧑 YOU write it · 🤖 CLAUDE CODE scaffolds/styles it.
Backend before frontend, as always.

---

## The claim model (what changed vs the old plan)
- Offers are **fixed price** → **instant claim**. A merchant claims part of an
  offer's quantity; `offers.remaining_quantity` decrements **immediately** — no
  farmer approval, no pending state, no race condition.
- `Order.status` is a **delivery lifecycle** (placed → accepted → packing →
  in_transit → delivered, + cancelled) — NOT pending/approved/declined.
- Negotiation / a request+approve flow is a **later enhancement**, built only if
  fixed price gives way to negotiated deals.

---

# FEATURE A — Order (a claim against an Offer)

## Milestone A.1 — Data layer (👀 backend)
- 🤖 Scaffold: `make:model Order -mfs`, policy, resource controller.
- 🧑 `OrderStatus` enum: `Placed` / `Accepted` / `Packing` / `InTransit` /
  `Delivered` / `Cancelled`.
- 🧑 Migration `orders`: `offer_id` FK (cascade), `user_id` (merchant),
  `quantity` (unsigned integer, **base unit**), `price` (integer **minor
  units** — **snapshot at purchase**, via the `Money` cast), `status` (string,
  default `placed`), `note` (text, nullable), `timestamps`, `softDeletes()`.
- 🧑 Model: `$fillable`, `casts()` (enum + `Money`), `offer()`
  (`belongsTo`), `merchant()` (`belongsTo(User::class, 'user_id')`).
- 🧑 **See it:** create a claim in tinker. 👀

## Milestone A.2 — Placing a claim decrements the offer (👀 backend: the key rule)
- 🧑 `store`: validate `quantity <= offer->remaining_quantity`, then within a DB
  **transaction** create the order and decrement `remaining_quantity` (snapshot
  the offer's price onto the order). Close the offer when it hits zero.
  *Concept: DB transactions keep the create + decrement atomic.*
- 🧑 **See it:** claim 300kg of a 1000kg offer → offer shows 700kg remaining. 👀
- 🧑 Routes: claim create/store behind `['auth','role:merchant']`.

## Milestone A.3 — The reusable campaign-detail claims list (👀 frontend)
- 🤖 One reusable "offer detail with claims list" component: offer summary +
  progress bar on top, a list of incoming orders/claims below (counterparty,
  quantity, status). Serves **both** roles.
- Farmer's Orders = their offers + incoming merchant claims.
  Merchant's Orders = their placed claims (+ later, their demands).
- 🧑 `<script setup>`: typed props for the offer + its claims.

## Milestone A.4 — Delivery lifecycle + notifications (👀 frontend)
- 🧑 Status transitions (accepted → packing → in_transit → delivered), guarded
  by policy (who may advance which step). Cancellation rules.
- 🧑 Notifications on status changes.

---

# FEATURE B — Demand (merchant buy-offer, the Offer mirror)
- The buy side: a merchant posts "I want to buy X" — a separate entity mirroring
  Offer. Surfaces on the Market's **Buying** tab (amber "BUYING" badge), which
  becomes the farmer's role-aware default.
- Same CRUD + owner-only writes recipe as Offer; farmers can claim against a
  demand the same way merchants claim against an offer (symmetric — reuse the
  campaign-detail component).

---

# Phase 4 — Definition of done (draft)
- [ ] Merchant claims part of an offer; `remaining_quantity` decrements atomically.
- [ ] Reusable campaign-detail claims list serves both roles.
- [ ] Order delivery lifecycle + notifications work.
- [ ] Demand (buy-offer) built; Market Buying tab populated.
- [ ] Pint + PHPStan clean.
