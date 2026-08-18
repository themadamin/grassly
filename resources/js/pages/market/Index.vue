<template>
    <Head title="Market" />

    <GrasslyAppLayout title="Market">
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

            <template v-else>
                <div class="relative mb-[22px]">
                    <div class="flex flex-wrap items-center gap-2.5">
                        <div
                            class="relative min-w-[200px] flex-1 basis-[260px]"
                        >
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
                            <input
                                v-model="search"
                                type="search"
                                placeholder="Search offers, crops, descriptions…"
                                class="w-full rounded-xl border border-[#E8EAE2] bg-white py-[11px] pr-3.5 pl-10 text-sm font-medium text-ink outline-none placeholder:text-[#6B7260]"
                            />
                        </div>

                        <button
                            type="button"
                            class="relative flex size-11 flex-none cursor-pointer items-center justify-center rounded-xl bg-white"
                            :class="filterButtonClass"
                            @click="togglePanel"
                        >
                            <svg
                                width="18"
                                height="18"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#0F1510"
                                stroke-width="2.1"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M4 5 H20 L14 13 V19 L10 21 V13 Z" />
                            </svg>
                            <span
                                v-if="stagedFilterCount > 0"
                                class="absolute -top-1.5 -right-1.5 flex h-[18px] min-w-[18px] items-center justify-center rounded-full border-2 border-stone bg-lime px-1 text-[11px] font-extrabold text-ink"
                            >
                                {{ stagedFilterCount }}
                            </span>
                        </button>

                        <div class="relative flex-none">
                            <select
                                v-model="sort"
                                class="cursor-pointer appearance-none rounded-xl border border-[#E8EAE2] bg-white py-[11px] pr-9 pl-[15px] text-[13px] font-bold text-ink outline-none"
                            >
                                <option
                                    v-for="option in sortOptions"
                                    :key="option.value"
                                    :value="option.value"
                                >
                                    {{ option.label }}
                                </option>
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

                        <button
                            type="button"
                            class="flex-none cursor-pointer rounded-xl bg-lime px-[22px] py-[11px] text-[13px] font-extrabold text-ink"
                            @click="applyFilters"
                        >
                            Apply
                        </button>
                    </div>

                    <div
                        v-if="panelOpen"
                        class="fixed inset-0 z-40"
                        @click="closePanel"
                    ></div>
                    <div
                        v-if="panelOpen"
                        class="absolute top-[calc(100%+10px)] left-0 z-50 w-[440px] rounded-[18px] border border-[#E8EAE2] bg-white p-5 shadow-[0_18px_40px_rgba(15,21,16,0.14)]"
                    >
                        <div
                            class="mb-2.5 text-[11px] font-extrabold tracking-[0.1em] text-[#8A9180] uppercase"
                        >
                            Category
                        </div>
                        <div class="mb-5 flex flex-wrap gap-2">
                            <button
                                v-for="option in categoryOptions"
                                :key="option.id ?? 'all'"
                                type="button"
                                class="cursor-pointer rounded-full px-4 py-2 text-[13px] font-bold whitespace-nowrap"
                                :class="categoryChipClass(option.id)"
                                @click="selectCategory(option.id)"
                            >
                                {{ option.name }}
                            </button>
                        </div>

                        <div
                            class="mb-2.5 text-[11px] font-extrabold tracking-[0.1em] text-[#8A9180] uppercase"
                        >
                            Crop
                        </div>
                        <div class="relative mb-2.5">
                            <input
                                v-model="cropQuery"
                                type="text"
                                placeholder="Type to filter crops…"
                                class="w-full rounded-[10px] border border-[#E8EAE2] bg-white px-[13px] py-2.5 text-[13px] font-medium text-ink outline-none"
                                @input="onCropQueryInput"
                            />
                            <div
                                v-if="cropOptions.length > 0"
                                class="absolute top-[calc(100%+4px)] right-0 left-0 z-10 overflow-hidden rounded-[10px] border border-[#E8EAE2] bg-white shadow-[0_10px_24px_rgba(15,21,16,0.12)]"
                            >
                                <div
                                    v-for="option in cropOptions"
                                    :key="option.id"
                                    class="cursor-pointer px-[13px] py-2.5 text-[13px] font-semibold text-ink hover:bg-stone"
                                    @click="selectCrop(option)"
                                >
                                    {{ option.name }}
                                </div>
                            </div>
                        </div>
                        <div
                            v-if="selectedCropName"
                            class="mb-5 flex flex-wrap gap-1.5"
                        >
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-lime-pale py-[5px] pr-2 pl-3 text-xs font-bold text-[#3F5610]"
                            >
                                {{ selectedCropName }}
                                <svg
                                    class="cursor-pointer"
                                    width="11"
                                    height="11"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#3F5610"
                                    stroke-width="2.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    @click="clearCrop"
                                >
                                    <path d="M6 6 L18 18" />
                                    <path d="M18 6 L6 18" />
                                </svg>
                            </span>
                        </div>

                        <div
                            class="mb-2.5 text-[11px] font-extrabold tracking-[0.1em] text-[#8A9180] uppercase"
                        >
                            Region
                        </div>
                        <div class="mb-5 flex flex-wrap gap-2">
                            <button
                                v-for="option in regionOptions"
                                :key="option.id ?? 'all'"
                                type="button"
                                class="cursor-pointer rounded-full px-4 py-2 text-[13px] font-bold whitespace-nowrap"
                                :class="regionChipClass(option.id)"
                                @click="selectRegion(option.id)"
                            >
                                {{ option.name }}
                            </button>
                        </div>

                        <div
                            class="mb-2.5 text-[11px] font-extrabold tracking-[0.1em] text-[#8A9180] uppercase"
                        >
                            Availability
                        </div>
                        <div
                            class="mb-5 inline-flex gap-1 rounded-xl bg-stone p-1"
                        >
                            <button
                                type="button"
                                class="cursor-pointer rounded-[10px] px-4 py-[9px] text-[13px] font-bold"
                                :class="availabilityChipClass('available_now')"
                                @click="setAvailability('available_now')"
                            >
                                Available now
                            </button>
                            <button
                                type="button"
                                class="cursor-pointer rounded-[10px] px-4 py-[9px] text-[13px] font-bold"
                                :class="availabilityChipClass(null)"
                                @click="setAvailability(null)"
                            >
                                Any
                            </button>
                        </div>

                        <div
                            class="mb-2.5 text-[11px] font-extrabold tracking-[0.1em] text-[#8A9180] uppercase"
                        >
                            Date range
                        </div>
                        <div class="mb-5 flex items-center gap-2">
                            <input
                                v-model="dateFrom"
                                type="date"
                                class="flex-1 rounded-[10px] border border-[#E8EAE2] bg-white px-[11px] py-2.5 text-[13px] font-medium text-ink outline-none"
                            />
                            <span class="text-xs font-bold text-[#8A9180]"
                                >to</span
                            >
                            <input
                                v-model="dateTo"
                                type="date"
                                class="flex-1 rounded-[10px] border border-[#E8EAE2] bg-white px-[11px] py-2.5 text-[13px] font-medium text-ink outline-none"
                            />
                        </div>

                        <div
                            class="mb-2.5 text-[11px] font-extrabold tracking-[0.1em] text-[#8A9180] uppercase"
                        >
                            Price range
                        </div>
                        <div class="mb-5 flex items-center gap-2">
                            <div class="relative flex-1">
                                <span
                                    class="absolute top-1/2 left-[11px] -translate-y-1/2 text-[13px] font-bold text-[#8A9180]"
                                    >$</span
                                >
                                <MoneyInput
                                    v-model="priceMin"
                                    placeholder="Min"
                                    class="w-full rounded-[10px] border border-[#E8EAE2] bg-white py-2.5 pr-[11px] pl-6 text-[13px] font-medium text-ink outline-none"
                                />
                            </div>
                            <span class="text-xs font-bold text-[#8A9180]"
                                >to</span
                            >
                            <div class="relative flex-1">
                                <span
                                    class="absolute top-1/2 left-[11px] -translate-y-1/2 text-[13px] font-bold text-[#8A9180]"
                                    >$</span
                                >
                                <MoneyInput
                                    v-model="priceMax"
                                    placeholder="Max"
                                    class="w-full rounded-[10px] border border-[#E8EAE2] bg-white py-2.5 pr-[11px] pl-6 text-[13px] font-medium text-ink outline-none"
                                />
                            </div>
                        </div>

                        <div
                            class="flex items-center justify-between border-t border-[#E8EAE2] pt-1.5"
                        >
                            <button
                                type="button"
                                class="cursor-pointer text-xs font-bold text-[#6B7260] underline"
                                @click="clearPanelFilters"
                            >
                                Clear all
                            </button>
                            <span class="text-xs text-[#8A9180]"
                                >Apply to commit changes</span
                            >
                        </div>
                    </div>
                </div>

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

                <template v-if="offers.data.length > 0">
                    <div class="mb-4 text-sm font-bold">
                        {{ offers.meta.total }}
                        {{ offers.meta.total === 1 ? 'offer' : 'offers' }}
                    </div>

                    <div
                        class="grid grid-cols-[repeat(auto-fill,minmax(290px,1fr))] gap-5"
                    >
                        <article
                            v-for="offer in offers.data"
                            :key="offer.id"
                            class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                        >
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
                                    {{ offer.product.crop.category.name }}
                                </span>
                            </div>

                            <div class="p-[18px]">
                                <div
                                    class="mb-0.5 text-[18px] font-extrabold tracking-[-0.01em]"
                                >
                                    {{ offer.title }}
                                </div>
                                <!-- TODO(you): the farmer's display name isn't in
                                     OfferListItemData yet. To show it (design =
                                     "Maria Okonkwo · Riverside Valley"), eager-load
                                     `farmer` in MarketController and add a
                                     `farmer_name` field to OfferListItemResource +
                                     OfferListItemData, then render it here. For now
                                     only the regions are shown. -->
                                <div
                                    class="mb-[14px] text-[13px] text-[#6B7260]"
                                >
                                    {{
                                        offer.regions
                                            .map((r) => r.name)
                                            .join(', ')
                                    }}
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
import { computed, ref } from 'vue';
import OfferController from '@/actions/App/Http/Controllers/OfferController';
import MoneyInput from '@/components/shared/MoneyInput.vue';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';
import type { UserRole } from '@/types/auth';
import type { Category } from '@/types/category';
import type { Crop } from '@/types/crop';
import type { OfferListItem } from '@/types/offer';
import type { Paginated } from '@/types/pagination';
import type { Region } from '@/types/region';

const props = withDefaults(
    defineProps<{
        offers?: Paginated<OfferListItem>;
        tab?: App.Enums.MarketTab;
        filters?: App.Data.Filters.MarketFilterData;
        categories?: Category[];
        regions?: Region[];
    }>(),
    {
        offers: () => ({
            data: [],
            links: { first: null, last: null, prev: null, next: null },
            meta: {
                current_page: 1,
                from: null,
                last_page: 1,
                links: [],
                path: '',
                per_page: 20,
                to: null,
                total: 0,
            },
        }),
        tab: 'selling',
        filters: () => ({
            search: null,
            category: null,
            crop: null,
            region: null,
            availability: null,
            date_from: null,
            date_to: null,
            price_min: null,
            price_max: null,
            sort: null,
        }),
        categories: () => [],
        regions: () => [],
    },
);

const page = usePage();
const role = computed<UserRole>(() => page.props.auth.role ?? 'farmer');

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

function tabClass(key: App.Enums.MarketTab): string {
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

// TODO(you): none of this re-syncs itself after a partial reload swaps
// `props.filters` for a new value (e.g. after Apply, or after removing a
// chip) — Vue doesn't do that for you once a prop's initial value has been
// copied into a ref. Once applyFilters()/removeFilter()/clearFilters() below
// actually visit the server, add a `watch(() => props.filters, (f) => {
// ...reset every ref here... })` or these controls will silently drift from
// what's really applied.

const panelOpen = ref(false);

function togglePanel() {
    panelOpen.value = !panelOpen.value;
}

function closePanel() {
    panelOpen.value = false;
}

const search = ref<string>(props.filters.search ?? '');
const sort = ref<App.Enums.MarketSortOption>(props.filters.sort ?? 'newest');

const sortOptions: { label: string; value: App.Enums.MarketSortOption }[] = [
    { label: 'Newest', value: 'newest' },
    { label: 'Oldest', value: 'oldest' },
    { label: 'Price low→high', value: 'price_asc' },
    { label: 'Price high→low', value: 'price_desc' },
    { label: 'Quantity', value: 'quantity' },
];

const category = ref<number | null>(props.filters.category);

const categoryOptions = computed(() => [
    { id: null as number | null, name: 'All' },
    ...props.categories,
]);

function categoryChipClass(id: number | null): string {
    return id === category.value
        ? 'bg-lime text-ink'
        : 'bg-stone text-[#5A6150]';
}

function selectCategory(id: number | null) {
    category.value = id;
}

const crop = ref<number | null>(props.filters.crop);
const selectedCropName = ref<string | null>(null);
const cropQuery = ref('');
const cropOptions = ref<Crop[]>([]);

function selectCrop(option: Crop) {
    crop.value = option.id;
    selectedCropName.value = option.name;
    cropQuery.value = '';
    cropOptions.value = [];
}

function clearCrop() {
    crop.value = null;
    selectedCropName.value = null;
}

// TODO(you): debounce this the same way you'll debounce the search box
// elsewhere, then GET /crops — the route helper is `index` from
// '@/routes/crops', e.g. `index({ query: { q: cropQuery.value, category:
// category.value } }).url`. Fetch it (this is a plain JSON endpoint, not an
// Inertia page — use `fetch()`, not `router.get()`) and set
// cropOptions.value to the parsed results.
// Concept: fetch() hits a JSON endpoint from client code; router.get() instead
// navigates/re-renders an Inertia page — different tools for different jobs.
function onCropQueryInput() {
    // TODO(you)
}

const region = ref<number | null>(props.filters.region);

const regionOptions = computed(() => [
    { id: null as number | null, name: 'All' },
    ...props.regions,
]);

function regionChipClass(id: number | null): string {
    return id === region.value
        ? 'bg-lime text-ink'
        : 'bg-stone text-[#5A6150]';
}

function selectRegion(id: number | null) {
    region.value = id;
}

const availability = ref<string | null>(props.filters.availability);

function availabilityChipClass(value: string | null): string {
    return value === availability.value
        ? 'bg-lime text-ink'
        : 'bg-transparent text-[#5A6150]';
}

function setAvailability(value: string | null) {
    availability.value = value;
}

const dateFrom = ref<string | null>(props.filters.date_from);
const dateTo = ref<string | null>(props.filters.date_to);

// price_min/price_max come back from the server in minor units (cents);
// MoneyInput takes major units (dollars), so divide by 100 for display.
const priceMin = ref<number | null>(
    props.filters.price_min !== null ? props.filters.price_min / 100 : null,
);
const priceMax = ref<number | null>(
    props.filters.price_max !== null ? props.filters.price_max / 100 : null,
);

const filterButtonClass = computed(() =>
    panelOpen.value
        ? 'border-[1.5px] border-lime'
        : 'border-[1.5px] border-[#E8EAE2]',
);

const stagedFilterCount = computed(() => {
    let count = 0;

    if (category.value !== null) {
        count++;
    }

    if (crop.value !== null) {
        count++;
    }

    if (region.value) {
        count++;
    }

    if (availability.value) {
        count++;
    }

    if (dateFrom.value || dateTo.value) {
        count++;
    }

    if (priceMin.value !== null || priceMax.value !== null) {
        count++;
    }

    return count;
});

function clearPanelFilters() {
    category.value = null;
    crop.value = null;
    selectedCropName.value = null;
    cropQuery.value = '';
    region.value = null;
    availability.value = null;
    dateFrom.value = null;
    dateTo.value = null;
    priceMin.value = null;
    priceMax.value = null;
}

type FilterChipKey =
    | 'search'
    | 'category'
    | 'crop'
    | 'region'
    | 'availability'
    | 'dates'
    | 'price';

const activeFilterChips = computed(() => {
    const f = props.filters;
    const chips: { key: FilterChipKey; label: string }[] = [];

    if (f.search) {
        chips.push({ key: 'search', label: `“${f.search}”` });
    }

    if (f.category !== null) {
        const match = props.categories.find((c) => c.id === f.category);
        chips.push({ key: 'category', label: match?.name ?? 'Category' });
    }

    if (f.crop !== null) {
        chips.push({ key: 'crop', label: 'Crop selected' });
    }

    if (f.region !== null) {
        const match = props.regions.find((r) => r.id === f.region);
        chips.push({ key: 'region', label: match?.name ?? 'Region' });
    }

    if (f.availability) {
        chips.push({ key: 'availability', label: 'Available now' });
    }

    if (f.date_from || f.date_to) {
        chips.push({ key: 'dates', label: 'Date range' });
    }

    if (f.price_min !== null || f.price_max !== null) {
        chips.push({ key: 'price', label: 'Price range' });
    }

    return chips;
});

const hasActiveFilters = computed(() => activeFilterChips.value.length > 0);

// TODO(you) [Milestone 4.1]: switching tabs should ask the controller for new
// results via an Inertia visit, not filter in the browser.
// Hint: router.get(market().url, { tab }, { preserveScroll: true, only: [...] })
// Concept — router.get(url, data, options) + PARTIAL RELOAD: passing
// `only: ['offers', 'tab', 'filters']` refetches just those props, so the
// sidebar and top bar don't re-render. `market` is exported from '@/routes':
// `import { market } from '@/routes'`, then `market().url`.
function setTab(tab: App.Enums.MarketTab) {
    void tab; // remove once implemented
    // TODO(you)
}

// TODO(you) [Milestone 4.2]: the big one. Collect every staged ref above
// (search, sort, category, crop, region, availability, dateFrom, dateTo,
// priceMin, priceMax) into ONE params object that mirrors
// App.Data.Filters.MarketFilterData (omit null/empty keys), then
// router.get(market().url, { tab: props.tab, ...params }, { only: ['offers',
// 'filters'], preserveState: true, preserveScroll: true, replace: true }).
// Close the panel too (closePanel()).
function applyFilters() {
    // TODO(you)
}

// TODO(you): drop one APPLIED filter (from props.filters, not the staged
// refs above) and re-visit the server without that key — same idea as
// applyFilters but built from props.filters minus `key`.
function removeFilter(key: FilterChipKey) {
    void key; // remove once implemented
    // TODO(you)
}

// TODO(you): clear every applied + staged filter — visit market().url with
// just the active tab, and reset every ref above (or re-seed them from the
// response once the visit resolves).
function clearFilters() {
    // TODO(you)
}
</script>
