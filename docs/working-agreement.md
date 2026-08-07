# Working agreement — how we build together

(Extracted from CLAUDE.md to keep that file lean. CLAUDE.md carries the 3-line summary;
this is the full version.)

The developer is learning Vue 3, TypeScript, Inertia, **and Laravel/PHP** by building this
app — they want to learn the **backend too**, not just the frontend. Across the whole stack
the rule is the same: **Claude scaffolds and teaches; the developer writes the logic.** Do
NOT implement their learning surface for them — stub it, give hints, explain the concept,
and hand it back. Only write a complete solution when the developer explicitly asks.

## Vue single-file components

**Claude Code owns:**
- `<template>` — HTML structure, semantic markup, accessibility
- Styling — Tailwind v4 classes, the Grassly design tokens, shadcn-vue composition
- Visual layout matching the Claude Design handoff
- Template bindings' SHAPE: write the `@click`, `v-for`, `v-model`, `:prop` references,
  but leave the logic behind them as stubs

**The developer owns (do NOT fill these in — stub and hand back):**
- `<script setup lang="ts">` logic — reactive state (ref/computed), event handlers, form
  logic, Inertia visits (useForm, router), composables
- TypeScript types / interfaces for props, emits, and data shapes
- Any business logic

**How to stub for the developer:**
- Declare the variables/functions the template needs, but leave bodies empty with a
  `// TODO(you): ...` comment explaining what it should do and a hint about the
  Vue/Inertia/TS concept involved.
- Example:
  ```ts
  // TODO(you): create a typed useForm for the listing fields below.
  // Hint: Inertia's useForm<T>() — define an interface for the form shape first.
  const form = /* TODO */;

  // TODO(you): POST to the store route on submit, handle validation errors.
  // Hint: form.post(route('offers.store'), { ... })
  function handleSubmit() { /* TODO */ }
  ```
- When a TypeScript concept comes up (generics, interfaces, type narrowing,
  `defineProps<T>()`), add a 1–2 line plain explanation in a comment — the developer is new to TS.

## Backend (PHP / Laravel) — same split

- **Claude owns:** class/file scaffolding (controller/model/migration/request skeletons,
  route SHAPE), boilerplate, and running tooling (Pint, PHPStan, tests).
- **The developer owns + is learning:** controller actions, model logic, validation rules,
  Eloquent queries, Fortify actions, enum methods, policies — the business logic. Stub
  method bodies with `// TODO(you): ...` plus a hint naming the Laravel concept (e.g.
  "Rule::enum()", "Eloquent relationship", "form request authorize()"), and explain it —
  don't fill it in.
- When a Laravel/PHP concept comes up (facades, service container, Eloquent relations,
  middleware, enums, events), add a 1–2 line plain explanation.

## When the developer asks for help with their part
Explain the concept and guide them; show small examples. Don't just write the whole
solution unless they explicitly ask for it — the code is their learning surface, frontend
and backend alike.

## Build order
Follow the phase roadmap. Build a screen only when its phase arrives; the designs for all
screens already exist (Claude Design). Backend before frontend, always.