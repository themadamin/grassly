<template>
    <Head title="My storage listings" />

    <GrasslyAppLayout title="My storage listings">
        <template #actions>
            <Link
                :href="createRoute()"
                class="inline-flex items-center gap-2 rounded-xl bg-lime px-[18px] py-[11px] text-sm font-bold text-ink no-underline transition-colors hover:bg-lime-dark"
            >
                <svg
                    width="15"
                    height="15"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="#0F1510"
                    stroke-width="2.6"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M12 5 V19" />
                    <path d="M5 12 H19" />
                </svg>
                New offer
            </Link>
        </template>

        <div
            v-if="offers.data.length === 0 && !hasActiveFilters"
            class="flex min-h-[560px] items-center justify-center p-7"
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
                            class="flex size-[74px] items-center justify-center rounded-[20px] bg-lime-pale"
                        >
                            <svg
                                width="38"
                                height="38"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#5C8A1A"
                                stroke-width="1.9"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M3 9 L12 4 L21 9 V20 H3 Z" />
                                <path d="M9 20 V13 H15 V20" />
                            </svg>
                        </span>
                    </div>
                    <span
                        class="absolute -right-1.5 -bottom-1.5 flex size-[38px] items-center justify-center rounded-full border-[3px] border-stone bg-lime"
                    >
                        <svg
                            width="18"
                            height="18"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#0F1510"
                            stroke-width="2.8"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M12 5 V19" />
                            <path d="M5 12 H19" />
                        </svg>
                    </span>
                </div>
                <h2
                    class="mb-2.5 text-[26px] font-extrabold tracking-[-0.02em]"
                >
                    No listings yet
                </h2>
                <p
                    class="mx-auto mb-6 max-w-[340px] text-[15px] leading-relaxed text-[#6B7260]"
                >
                    List the crops and storage space you have available, and
                    merchants nearby can find and order from you.
                </p>
                <Link
                    :href="OfferController.create().url"
                    class="inline-flex items-center gap-2.5 rounded-xl bg-lime px-[26px] py-3.5 text-[15px] font-bold text-ink no-underline transition-colors hover:bg-lime-dark"
                >
                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="#0F1510"
                        stroke-width="2.6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M12 5 V19" />
                        <path d="M5 12 H19" />
                    </svg>
                    Create your first listing
                </Link>
            </div>
        </div>

        <div v-else class="p-7">
            <div
                class="mb-[18px] flex flex-wrap items-center justify-between gap-3"
            >
                <div class="flex items-center gap-2.5">
                    <span class="text-sm font-bold"
                        >{{ offers.meta.total }} listings</span
                    >
                    <span
                        class="flex gap-[7px]"
                        role="tablist"
                        aria-label="Filter by status"
                    >
                        <button
                            v-for="tab in statusTabs"
                            :key="tab.label"
                            type="button"
                            role="tab"
                            :aria-selected="filters.status === tab.value"
                            class="rounded-full px-3 py-[5px] text-xs font-bold transition-colors"
                            :class="
                                filters.status === tab.value
                                    ? 'border border-[#E8EAE2] bg-white text-ink'
                                    : 'border border-transparent font-semibold text-[#6B7260] hover:text-ink'
                            "
                            @click="applyStatus(tab.value)"
                        >
                            {{ tab.label }}
                        </button>
                    </span>
                </div>

                <div class="flex items-center gap-2.5">
                    <label class="relative">
                        <span class="sr-only">Search listings</span>
                        <svg
                            class="pointer-events-none absolute top-1/2 left-3 -translate-y-1/2"
                            width="15"
                            height="15"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#9AA08E"
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
                            placeholder="Search title or crop…"
                            class="w-[220px] rounded-xl border border-[#E8EAE2] bg-white py-[9px] pr-3 pl-9 text-[13px] font-medium text-ink placeholder:text-[#9AA08E] focus:border-lime-dark focus:outline-none"
                            @input="onSearchInput"
                        />
                    </label>
                </div>
            </div>

            <div
                v-if="offers.data.length === 0"
                class="flex min-h-[320px] flex-col items-center justify-center gap-3 rounded-[20px] border border-dashed border-[#D8DBCF] bg-white/50 text-center"
            >
                <p class="text-[15px] font-bold text-ink">
                    No listings match these filters
                </p>
                <button
                    type="button"
                    class="text-[13px] font-bold text-lime-dark hover:underline"
                    @click="clearFilters"
                >
                    Clear filters
                </button>
            </div>

            <div
                v-else
                class="grid grid-cols-[repeat(auto-fill,minmax(290px,1fr))] gap-5"
            >
                <OfferCard
                    v-for="offer in offers.data"
                    :key="offer.id"
                    :offer="offer"
                    @delete="confirmDelete"
                />
            </div>

            <nav
                v-if="offers.meta.last_page > 1"
                class="mt-6 flex items-center justify-center gap-1.5"
                aria-label="Pagination"
            >
                <template v-for="(link, i) in offers.meta.links" :key="i">
                    <Link
                        v-if="link.url"
                        :href="link.url"
                        preserve-scroll
                        class="inline-flex min-w-9 items-center justify-center rounded-[10px] border px-3 py-2 text-[13px] font-bold no-underline transition-colors"
                        :class="
                            link.active
                                ? 'border-lime-dark bg-lime text-ink'
                                : 'border-[#E8EAE2] bg-white text-ink hover:bg-stone'
                        "
                        v-html="link.label"
                    />
                    <span
                        v-else
                        class="inline-flex min-w-9 items-center justify-center px-3 py-2 text-[13px] font-semibold text-[#9AA08E]"
                        v-html="link.label"
                    />
                </template>
            </nav>
        </div>

        <ConfirmDialog
            :open="deleteTarget !== null"
            title="Delete this offer?"
            :description="
                deleteTarget
                    ? `This permanently removes “${deleteTarget.title}” and any pending order requests tied to it. This can't be undone.`
                    : ''
            "
            confirm-label="Delete offer"
            variant="danger"
            @update:open="(value) => !value && cancelDelete()"
            @confirm="performDelete"
        >
            <template #icon>
                <svg
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="#E24B4A"
                    stroke-width="2.2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M5 7 H19" />
                    <path d="M9 7 V5 H15 V7" />
                    <path d="M7 7 L8 20 H16 L17 7" />
                    <path d="M10 11 V16" />
                    <path d="M14 11 V16" />
                </svg>
            </template>
        </ConfirmDialog>
    </GrasslyAppLayout>
</template>

<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import OfferController from '@/actions/App/Http/Controllers/OfferController';
import OfferCard from '@/components/offer/OfferCard.vue';
import ConfirmDialog from '@/components/shared/ConfirmDialog.vue';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';
import { create as createRoute } from '@/routes/offers/index';
import type { OfferListItem } from '@/types/offer';
import type { Paginated } from '@/types/pagination';

let debounceTimer: ReturnType<typeof setTimeout> | undefined;

const props = defineProps<{
    offers: Paginated<OfferListItem>;
    filters: App.Data.Filters.OfferFilterData;
}>();

const statusTabs: { label: string; value: App.Enums.OfferStatus | null }[] = [
    { label: 'All', value: null },
    { label: 'On sale', value: 'on_sale' },
    { label: 'Draft', value: 'draft' },
    { label: 'Closed', value: 'closed' },
];

const search = ref<string>(props.filters.search ?? '');
const status = ref<App.Enums.OfferStatus | null>(props.filters.status);

const hasActiveFilters = computed<boolean>(
    () => props.filters.status !== null || (props.filters.search ?? '') !== '',
);

function buildParams(): Record<string, string> {
    const params: Record<string, string> = {};
    if (status.value !== null) {
        params.status = status.value;
    }

    if (search.value !== '') {
        params.search = search.value;
    }

    return params;
}

function applyStatus(value: App.Enums.OfferStatus | null) {
    status.value = value;
    router.get(OfferController.index().url, buildParams(), {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
}

function onSearchInput() {
    if (debounceTimer !== undefined) {
        clearTimeout(debounceTimer);
    }

    debounceTimer = setTimeout(() => {
        debounceTimer = undefined;
        router.get(OfferController.index().url, buildParams(), {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    }, 300);
}

function clearFilters() {
    search.value = '';
    status.value = null;
    clearTimeout(debounceTimer);
    router.get(OfferController.index().url, {}, {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
}

const deleteTarget = ref<OfferListItem | null>(null);

function confirmDelete(offer: OfferListItem) {
    deleteTarget.value = offer;
}

function cancelDelete() {
    deleteTarget.value = null;
}

function performDelete() {
    if (!deleteTarget.value) {
        return;
    }

    router.delete(OfferController.destroy(deleteTarget.value.id).url, {
        onSuccess: () => cancelDelete(),
    });
}
</script>
