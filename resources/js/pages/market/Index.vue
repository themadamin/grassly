<template>
    <Head title="Market" />

    <GrasslyAppLayout title="Market">
        <!-- Role-view pill in the top bar (design frames 13–15). Farmers and
             merchants share this page; the pill just signals whose view it is. -->
        <template #actions>
            <span
                class="inline-flex items-center gap-1.5 rounded-full px-3 py-[5px] text-xs font-bold"
                :class="rolePill.wrap"
            >
                <span
                    class="size-1.5 rounded-full"
                    :class="rolePill.dot"
                ></span>
                {{ rolePill.label }}
            </span>
        </template>

        <div class="flex min-h-full flex-col p-7">
            <!-- SEGMENTED TABS (All / Selling / Buying) -->
            <div class="mb-5 flex items-center justify-between">
                <div
                    class="inline-flex gap-1 rounded-[14px] border border-[#E8EAE2] bg-white p-[5px]"
                >
                    <button
                        type="button"
                        :class="tabClass('all')"
                        @click="setTab('all')"
                    >
                        All
                    </button>
                    <button
                        type="button"
                        :class="tabClass('selling')"
                        @click="setTab('selling')"
                    >
                        Selling
                    </button>
                    <button
                        type="button"
                        :class="tabClass('buying')"
                        @click="setTab('buying')"
                    >
                        Buying
                    </button>
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- BUYING TAB — Demands are Phase 4, so show a coming-soon state -->
            <!-- ============================================================ -->
            <div
                v-if="tab === 'buying'"
                class="flex min-h-[480px] flex-1 items-center justify-center"
            >
                <div class="max-w-[420px] text-center">
                    <div class="relative mx-auto mb-7 size-[130px]">
                        <div
                            class="absolute inset-0 rounded-[28px] border border-[#E8EAE2] bg-white"
                        ></div>
                        <div
                            class="absolute inset-0 rounded-[28px]"
                            style="
                                background-image: repeating-radial-gradient(
                                    circle at 70% 28%,
                                    transparent 0 14px,
                                    rgba(15, 21, 16, 0.04) 14px 15.5px
                                );
                            "
                        ></div>
                        <div
                            class="absolute inset-0 flex items-center justify-center"
                        >
                            <span
                                class="flex size-[74px] items-center justify-center rounded-[20px] bg-[#FAEEDA]"
                            >
                                <svg
                                    width="36"
                                    height="36"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#9A6210"
                                    stroke-width="1.9"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M9 4 H15 L20 9 V20 H4 V9 Z" />
                                    <path d="M9 4 V9 H4" />
                                    <path d="M9 13 H15" />
                                    <path d="M9 16.5 H13" />
                                </svg>
                            </span>
                        </div>
                        <span
                            class="absolute -right-1.5 -bottom-1.5 flex size-[38px] items-center justify-center rounded-full border-[3px] border-stone bg-[#EF9F27]"
                        >
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#fff"
                                stroke-width="2.4"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 8 V13" />
                                <path d="M12 16.2 V16.5" />
                            </svg>
                        </span>
                    </div>
                    <h2
                        class="mb-2.5 text-[26px] font-extrabold tracking-[-0.02em]"
                    >
                        Buying demands are coming soon
                    </h2>
                    <p
                        class="mx-auto mb-[26px] max-w-[360px] text-[15px] leading-relaxed text-[#6B7260]"
                    >
                        Soon you’ll be able to post what you need and let
                        farmers come to you. This tab will list public demands
                        once that feature ships.
                    </p>
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-[#E8EAE2] bg-white px-[18px] py-[9px] text-[13px] font-bold text-[#5A6150]"
                    >
                        <svg
                            width="14"
                            height="14"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#5A6150"
                            stroke-width="2.4"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 8 V12 L15 14" />
                        </svg>
                        Planned for Phase 4
                    </span>
                </div>
            </div>

            <!-- ============================================================ -->
            <!-- SELLING / ALL TABS — toolbar + results (or no-results state)  -->
            <!-- ============================================================ -->
            <template v-else>
                <!-- TOOLBAR: search + crop/region/availability selects.
                     Server-driven filters — the SHAPE is here; wiring is yours
                     (see the <script setup> TODOs). -->
                <div class="mb-[14px] flex flex-wrap items-center gap-3">
                    <div class="relative min-w-[240px] flex-1">
                        <svg
                            class="absolute top-1/2 left-3.5 -translate-y-1/2"
                            width="17"
                            height="17"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#6B7260"
                            stroke-width="2.2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <circle cx="11" cy="11" r="7" />
                            <path d="M21 21 L16.5 16.5" />
                        </svg>
                        <!-- TODO(you): replace :value with v-model on a reactive
                             filter ref, then debounce applyFilters(). -->
                        <input
                            type="search"
                            placeholder="Search offers by crop, farmer, region…"
                            :value="filters.search ?? ''"
                            class="w-full rounded-xl border border-[#E8EAE2] bg-white py-[11px] pr-3.5 pl-10 text-sm font-medium text-ink outline-none placeholder:text-[#6B7260]"
                            @input="applyFilters"
                        />
                    </div>

                    <!-- Crop -->
                    <div class="relative">
                        <select
                            :value="filters.crop ?? ''"
                            class="cursor-pointer appearance-none rounded-xl border border-[#E8EAE2] bg-white py-[11px] pr-9 pl-[15px] text-[13px] font-bold text-ink outline-none"
                            @change="applyFilters"
                        >
                            <!-- TODO(you): populate crop options from a prop the
                                 controller passes (distinct product crops). -->
                            <option value="">Any crop</option>
                            <option>Produce</option>
                            <option>Grain</option>
                            <option>Fruit</option>
                        </select>
                        <svg
                            class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2"
                            width="14"
                            height="14"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#6B7260"
                            stroke-width="2.4"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M6 9 L12 15 L18 9" />
                        </svg>
                    </div>

                    <!-- Region -->
                    <div class="relative">
                        <select
                            :value="filters.region ?? ''"
                            class="cursor-pointer appearance-none rounded-xl border border-[#E8EAE2] bg-white py-[11px] pr-9 pl-[15px] text-[13px] font-bold text-ink outline-none"
                            @change="applyFilters"
                        >
                            <!-- TODO(you): populate region options from a prop. -->
                            <option value="">Any region</option>
                            <option>Riverside Valley</option>
                            <option>Hillside Plots</option>
                        </select>
                        <svg
                            class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2"
                            width="14"
                            height="14"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#6B7260"
                            stroke-width="2.4"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M6 9 L12 15 L18 9" />
                        </svg>
                    </div>

                    <!-- Availability -->
                    <div class="relative">
                        <select
                            :value="filters.availability ?? ''"
                            class="cursor-pointer appearance-none rounded-xl border border-[#E8EAE2] bg-white py-[11px] pr-9 pl-[15px] text-[13px] font-bold text-ink outline-none"
                            @change="applyFilters"
                        >
                            <option value="">Any availability</option>
                            <option>Available now</option>
                            <option>Upcoming</option>
                        </select>
                        <svg
                            class="pointer-events-none absolute top-1/2 right-3 -translate-y-1/2"
                            width="14"
                            height="14"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#6B7260"
                            stroke-width="2.4"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M6 9 L12 15 L18 9" />
                        </svg>
                    </div>
                </div>

                <!-- ACTIVE FILTER CHIPS (only when a filter is set) -->
                <div
                    v-if="hasActiveFilters"
                    class="mb-6 flex flex-wrap items-center gap-2"
                >
                    <span
                        v-for="chip in activeFilterChips"
                        :key="chip.key"
                        class="inline-flex items-center gap-[7px] rounded-full border border-[#E8EAE2] bg-white py-1.5 pr-2 pl-[13px] text-xs font-bold text-ink"
                    >
                        {{ chip.label }}
                        <button
                            type="button"
                            class="flex cursor-pointer items-center"
                            :aria-label="`Remove ${chip.label} filter`"
                            @click="removeFilter(chip.key)"
                        >
                            <svg
                                width="12"
                                height="12"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#6B7260"
                                stroke-width="2.6"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M6 6 L18 18" />
                                <path d="M18 6 L6 18" />
                            </svg>
                        </button>
                    </span>
                    <button
                        type="button"
                        class="ml-1 cursor-pointer text-xs font-bold text-[#6B7260] underline"
                        @click="clearFilters()"
                    >
                        Clear all
                    </button>
                </div>

                <!-- RESULTS GRID -->
                <template v-if="offers.length > 0">
                    <div class="mb-4 text-sm font-bold">
                        {{ offers.length }}
                        {{ offers.length === 1 ? 'offer' : 'offers' }}
                    </div>

                    <div
                        class="grid grid-cols-[repeat(auto-fill,minmax(290px,1fr))] gap-5"
                    >
                        <article
                            v-for="offer in offers"
                            :key="offer.id"
                            class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                        >
                            <!-- Lime header band: SELLING badge + crop category -->
                            <div
                                class="relative flex h-[62px] items-center justify-between px-[18px]"
                                style="
                                    background-color: #a8e63d;
                                    background-image: repeating-radial-gradient(
                                        circle at 85% 30%,
                                        transparent 0 12px,
                                        rgba(15, 21, 16, 0.07) 12px 13.5px
                                    );
                                "
                            >
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-ink px-[11px] py-1 text-[11px] font-extrabold tracking-[0.08em] text-lime uppercase"
                                >
                                    <svg
                                        width="11"
                                        height="11"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="#A8E63D"
                                        stroke-width="3"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path d="M4 17 L10 11 L14 15 L20 7" />
                                    </svg>
                                    Selling
                                </span>
                                <span
                                    class="text-xs font-extrabold tracking-[0.1em] text-[#3F5610] uppercase"
                                >
                                    {{ offer.product.name }}
                                </span>
                            </div>

                            <div class="p-[18px]">
                                <div
                                    class="mb-0.5 text-[18px] font-extrabold tracking-[-0.01em]"
                                >
                                    {{ offer.title }}
                                </div>
                                <!-- Farmer · region sub-line.
                                     TODO(you): the farmer's display name isn't in
                                     OfferListItemData yet. To show it (design =
                                     "Maria Okonkwo · Riverside Valley"), eager-load
                                     `farmer` in MarketController and add a
                                     `farmer_name` field to OfferListItemResource +
                                     OfferListItemData, then render it here. For now
                                     only the region is shown. -->
                                <div
                                    class="mb-[14px] text-[13px] text-[#6B7260]"
                                >
                                    {{ offer.region }}
                                </div>

                                <div
                                    class="mb-3 flex items-end justify-between"
                                >
                                    <div
                                        class="text-[24px] font-extrabold tracking-[-0.03em] text-[#7AB82A]"
                                    >
                                        {{ offer.price_formatted
                                        }}<span
                                            class="text-[13px] font-semibold text-[#6B7260]"
                                            >/{{ offer.unit }}</span
                                        >
                                    </div>
                                    <div
                                        class="text-[13px] font-bold text-[#6B7260]"
                                    >
                                        {{ offer.total_display }} total
                                    </div>
                                </div>

                                <!-- Fulfillment progress. reserved = total −
                                     remaining (Phase 3: 0 until Phase 4 orders
                                     decrement remaining_quantity). Bar turns amber
                                     when nearly sold out. -->
                                <div class="mb-4">
                                    <div
                                        class="mb-1.5 h-1.5 overflow-hidden rounded-full bg-stone"
                                    >
                                        <div
                                            class="h-full rounded-full"
                                            :class="barColor(offer)"
                                            :style="{ width: barWidth(offer) }"
                                        ></div>
                                    </div>
                                    <div class="text-xs text-[#6B7260]">
                                        {{ reservedLabel(offer) }}
                                    </div>
                                </div>

                                <Link
                                    :href="OfferController.show(offer.id).url"
                                    class="block w-full rounded-[10px] border border-[#E8EAE2] bg-white py-[11px] text-center text-[13px] font-bold text-ink no-underline transition-colors hover:bg-stone"
                                >
                                    View offer
                                </Link>
                            </div>
                        </article>
                    </div>
                </template>

                <!-- NO RESULTS (filtered or empty) -->
                <div
                    v-else
                    class="flex min-h-[400px] flex-1 items-center justify-center"
                >
                    <div class="max-w-[380px] text-center">
                        <div
                            class="mx-auto mb-[22px] flex size-[88px] items-center justify-center rounded-[22px] border border-[#E8EAE2] bg-white"
                        >
                            <svg
                                width="38"
                                height="38"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#9AA08E"
                                stroke-width="1.9"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <circle cx="11" cy="11" r="7" />
                                <path d="M21 21 L16.5 16.5" />
                            </svg>
                        </div>
                        <h2
                            class="mb-2.5 text-[22px] font-extrabold tracking-[-0.02em]"
                        >
                            No offers match your filters
                        </h2>
                        <p
                            class="mx-auto mb-[22px] max-w-[320px] text-sm leading-relaxed text-[#6B7260]"
                        >
                            Try a different crop, widen the region, or clear
                            your search to see everything available.
                        </p>
                        <button
                            v-if="hasActiveFilters"
                            type="button"
                            class="inline-flex cursor-pointer items-center gap-2 rounded-xl border border-[#E8EAE2] bg-white px-[22px] py-3 text-sm font-bold text-ink transition-colors hover:bg-stone"
                            @click="clearFilters()"
                        >
                            Clear filters
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </GrasslyAppLayout>
</template>

<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import OfferController from '@/actions/App/Http/Controllers/OfferController';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';
import type { UserRole } from '@/types/auth';
import type { OfferListItem } from '@/types/offer';

// ─────────────────────────────────────────────────────────────────────────────
// PROPS — the shapes MarketController's __invoke() echoes back. `offers` is the
// hand-written list shape `OfferListItem` (resources/js/types/offer/index.ts,
// mirrors App\Http\Resources\OfferListItemResource). `tab`/`filters` mirror the
// controller's query state so the Market stays SERVER-driven.
//
// TODO(you): if you change the controller payload (e.g. add crop/region option
// lists, or a farmer_name field), refine these types to match.
type MarketTab = 'all' | 'selling' | 'buying';
type MarketFilters = {
    search: string | null;
    crop: string | null;
    region: string | null;
    availability: string | null;
};

const props = withDefaults(
    defineProps<{
        offers?: OfferListItem[];
        tab?: MarketTab;
        filters?: MarketFilters;
    }>(),
    {
        offers: () => [],
        tab: 'selling',
        filters: () => ({
            search: null,
            crop: null,
            region: null,
            availability: null,
        }),
    },
);

// ─────────────────────────────────────────────────────────────────────────────
// PRESENTATIONAL HELPERS (styling/formatting — safe to keep as-is).

const page = usePage();
const role = computed<UserRole>(() => page.props.auth.role ?? 'farmer');

// Top-bar "Farmer view" / "Merchant view" pill.
const rolePill = computed(() =>
    role.value === 'merchant'
        ? {
              label: 'Merchant view',
              wrap: 'border border-[#E8EAE2] bg-stone text-[#5A6150]',
              dot: 'bg-[#9AA08E]',
          }
        : {
              label: 'Farmer view',
              wrap: 'bg-lime-pale text-[#3F5610]',
              dot: 'bg-[#7AB82A]',
          },
);

// Segmented-tab styling keyed off the active `tab` prop.
function tabClass(key: MarketTab): string {
    const base =
        'cursor-pointer rounded-[10px] px-5 py-[9px] text-sm font-bold transition-colors';

    return key === props.tab
        ? `${base} bg-lime text-ink`
        : `${base} bg-transparent text-[#6B7260] hover:text-ink`;
}

// Fulfillment progress: reserved share of the offer's total quantity.
function reservedFraction(offer: OfferListItem): number {
    if (offer.total_quantity <= 0) {
        return 0;
    }

    return (
        (offer.total_quantity - offer.remaining_quantity) / offer.total_quantity
    );
}

function barWidth(offer: OfferListItem): string {
    return `${Math.round(reservedFraction(offer) * 100)}%`;
}

// Amber once ~90%+ reserved (near sold out), lime otherwise.
function barColor(offer: OfferListItem): string {
    return reservedFraction(offer) >= 0.9 ? 'bg-[#EF9F27]' : 'bg-lime';
}

function reservedLabel(offer: OfferListItem): string {
    const reserved = offer.total_quantity - offer.remaining_quantity;

    return `${reserved} ${offer.unit} reserved · ${offer.remaining_quantity} ${offer.unit} left`;
}

// Active filter chips, derived from the echoed filter values.
const activeFilterChips = computed(() => {
    const f = props.filters;
    const chips: { key: keyof MarketFilters; label: string }[] = [];

    if (f.search) {
        chips.push({ key: 'search', label: `“${f.search}”` });
    }

    if (f.crop) {
        chips.push({ key: 'crop', label: f.crop });
    }

    if (f.region) {
        chips.push({ key: 'region', label: f.region });
    }

    if (f.availability) {
        chips.push({ key: 'availability', label: f.availability });
    }

    return chips;
});

const hasActiveFilters = computed(() => activeFilterChips.value.length > 0);

// ─────────────────────────────────────────────────────────────────────────────
// YOUR LEARNING SURFACE — the server round-trips. The template already wires the
// @click / :value SHAPES to the functions below; you fill in the bodies.
//
// The Market is server-driven: switching tabs or changing filters should ask the
// controller for new results, NOT filter in the browser. Use an Inertia visit.
//   Concept — router.get(url, data, options) + PARTIAL RELOAD: passing
//   `only: ['offers', 'tab', 'filters']` refetches just those props, so the
//   sidebar and top bar don't re-render. `market` is exported from '@/routes':
//   `import { market } from '@/routes'`, then `market().url`.

// TODO(you) [Milestone 4.1]: visit the market route with the chosen tab.
// Hint: router.get(market().url, { tab }, { preserveScroll: true, only: [...] })
function setTab(tab: MarketTab) {
    void tab; // remove once implemented
    // TODO(you)
}

// TODO(you) [Milestone 4.2]: v-model the search + selects onto a reactive copy of
// `filters`, then debounce a router.get(market().url, { tab, ...filters }, ...).
// Concept: watch() the reactive filters + a small debounce so you don't fire a
// request on every keystroke; request()->query() reads them server-side.
function applyFilters() {
    // TODO(you)
}

// TODO(you): drop one filter (send the query without that key) then re-visit.
function removeFilter(key: keyof MarketFilters) {
    void key; // remove once implemented
    // TODO(you)
}

// TODO(you): clear every filter — visit market().url with just the active tab.
function clearFilters() {
    // TODO(you)
}
</script>
