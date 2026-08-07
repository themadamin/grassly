<template>
    <Head title="My storage listings" />

    <GrasslyAppLayout title="My storage listings">
        <!-- Topbar action -->
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

        <!-- EMPTY STATE (frame 08) -->
        <div
            v-if="offers.length === 0"
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

        <!-- LISTING GRID (frame 07) -->
        <div v-else class="p-7">
            <!-- Count + status filter pills -->
            <div class="mb-[18px] flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="text-sm font-bold"
                        >{{ offers.length }} listings</span
                    >
                    <!-- TODO(you): wire these filter pills in Milestone 1.5.
                         For now they're presentational only. Hint: a debounced
                         router.get(index.url, { only: ['offers'] }) with
                         a ?status= query param, read server-side with when(). -->
                    <span class="flex gap-[7px]">
                        <span
                            class="rounded-full border border-[#E8EAE2] bg-white px-3 py-[5px] text-xs font-bold text-ink"
                            >All</span
                        >
                        <span
                            class="rounded-full px-3 py-[5px] text-xs font-semibold text-[#6B7260]"
                            >On sale</span
                        >
                        <span
                            class="rounded-full px-3 py-[5px] text-xs font-semibold text-[#6B7260]"
                            >Draft</span
                        >
                        <span
                            class="rounded-full px-3 py-[5px] text-xs font-semibold text-[#6B7260]"
                            >Closed</span
                        >
                    </span>
                </div>
            </div>

            <!-- Cards -->
            <div
                class="grid grid-cols-[repeat(auto-fill,minmax(290px,1fr))] gap-5"
            >
                <article
                    v-for="offer in offers"
                    :key="offer.id"
                    class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                >
                    <!-- Lime header band: crop as the storage-type chip -->
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
                            class="text-xs font-extrabold tracking-[0.12em] text-[#3F5610] uppercase"
                            >{{ offer.product.name }}</span
                        >
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#0F1510"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M3 9 L12 4 L21 9 V20 H3 Z" />
                            <path d="M9 20 V13 H15 V20" />
                        </svg>
                    </div>

                    <div class="p-[18px]">
                        <div
                            class="mb-2.5 text-lg font-extrabold tracking-[-0.01em]"
                        >
                            {{ offer.title }}
                        </div>

                        <div class="mb-4 flex flex-col gap-[7px]">
                            <div
                                class="flex items-center gap-2 text-[13px] text-[#6B7260]"
                            >
                                <svg
                                    width="14"
                                    height="14"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#9AA08E"
                                    stroke-width="2.2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path
                                        d="M12 21 C12 21 5 14 5 9 a7 7 0 0 1 14 0 c0 5 -7 12 -7 12 Z"
                                    />
                                    <circle cx="12" cy="9" r="2.4" />
                                </svg>
                                {{ offer.region }}
                            </div>
                            <div
                                class="flex items-center gap-2 text-[13px] text-[#6B7260]"
                            >
                                <svg
                                    width="14"
                                    height="14"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#9AA08E"
                                    stroke-width="2.2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <rect
                                        x="4"
                                        y="5"
                                        width="16"
                                        height="16"
                                        rx="2.5"
                                    />
                                    <path d="M4 9 H20" />
                                    <path d="M8 3 V6" />
                                    <path d="M16 3 V6" />
                                </svg>
                                {{ formatDate(offer.available_from) }} –
                                {{
                                    offer.available_to
                                        ? formatDate(offer.available_to)
                                        : 'open'
                                }}
                            </div>
                            <div
                                class="flex items-center gap-2 text-[13px] text-[#6B7260]"
                            >
                                <svg
                                    width="14"
                                    height="14"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#9AA08E"
                                    stroke-width="2.2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M20 12 L12 4 H4 V12 L12 20 Z" />
                                    <circle cx="8" cy="8" r="1.4" />
                                </svg>
                                <span class="font-bold text-[#7AB82A]">{{
                                    offer.price_formatted
                                }}</span>
                            </div>
                        </div>

                        <div class="mb-4 flex items-end justify-between">
                            <div>
                                <div
                                    class="text-[26px] leading-none font-extrabold tracking-[-0.03em]"
                                >
                                    {{ offer.total_quantity }}
                                    <span class="text-base text-[#6B7260]">{{
                                        offer.unit
                                    }}</span>
                                </div>
                                <div class="mt-1 text-xs text-[#6B7260]">
                                    total quantity
                                </div>
                            </div>
                            <!-- Status pill — colours keyed off the enum value -->
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full px-[13px] py-1.5 text-xs font-bold capitalize"
                                :class="statusStyles[offer.status]?.chip"
                            >
                                <span
                                    class="size-1.5 rounded-full"
                                    :class="statusStyles[offer.status]?.dot"
                                ></span>
                                {{ offer.status_label }}
                            </span>
                        </div>

                        <!-- Card actions -->
                        <div
                            class="flex items-center gap-2 border-t border-[#E8EAE2] pt-3.5"
                        >
                            <Link
                                :href="OfferController.show(offer.id).url"
                                class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-[10px] border border-[#E8EAE2] bg-white py-[9px] text-[13px] font-bold text-ink no-underline transition-colors hover:bg-stone"
                            >
                                <svg
                                    width="14"
                                    height="14"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#0F1510"
                                    stroke-width="2.2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path
                                        d="M2 12 C4 7 8 5 12 5 C16 5 20 7 22 12 C20 17 16 19 12 19 C8 19 4 17 2 12 Z"
                                    />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                View
                            </Link>
                            <Link
                                :href="OfferController.edit(offer.id).url"
                                class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-[10px] border border-[#E8EAE2] bg-white py-[9px] text-[13px] font-bold text-ink no-underline transition-colors hover:bg-stone"
                            >
                                <svg
                                    width="14"
                                    height="14"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#0F1510"
                                    stroke-width="2.2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M4 20 H8 L18 10 L14 6 L4 16 Z" />
                                    <path d="M13 7 L17 11" />
                                </svg>
                                Edit
                            </Link>
                            <!-- Opens the confirm dialog; actual delete is Milestone 1.4 -->
                            <button
                                type="button"
                                class="flex size-10 flex-none items-center justify-center rounded-[10px] border border-[#E8EAE2] bg-white transition-colors hover:bg-stone"
                                aria-label="Delete offer"
                                @click="confirmDelete(offer)"
                            >
                                <svg
                                    width="15"
                                    height="15"
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
                                </svg>
                            </button>
                        </div>
                    </div>
                </article>
            </div>
        </div>

        <!-- DELETE CONFIRMATION — reusable dialog. `deleteTarget !== null` drives
             open; @update:open closes it (cancel/Esc/backdrop); @confirm deletes. -->
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
import { ref } from 'vue';
import OfferController from '@/actions/App/Http/Controllers/OfferController';
import ConfirmDialog from '@/components/grassly/ConfirmDialog.vue';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';
import { create as createRoute } from '@/routes/offers/index';
import type { OfferListItem } from '@/types/offer';

// Typed with the hand-written list shape. `OfferListItem` lives in
// resources/js/types/offer/index.ts and mirrors App\Http\Resources\OfferListItemResource
// (its enum fields import from @/types/enums).
//   Concept: defineProps<T>() is Vue's compile-time prop typing — T describes
//   the props the controller passes (here, `offers`).
// TODO(you) [Milestone 1.3]: when index() switches to pagination this becomes a
// paginated wrapper (e.g. { data: OfferListItem[]; meta: … }) rather than a
// plain array — type that wrapper here when you get there.
defineProps<{
    offers: OfferListItem[];
}>();

// Status → pill colours. Presentational config (keyed by the OfferStatus
// enum's string values) — leave as-is.
const statusStyles: Record<string, { chip: string; dot: string }> = {
    on_sale: { chip: 'bg-lime-pale text-[#3F5610]', dot: 'bg-[#7AB82A]' },
    draft: { chip: 'bg-[#E8EAE2] text-[#5A6150]', dot: 'bg-[#9AA08E]' },
    closed: { chip: 'bg-[#FBE4E3] text-[#B0302F]', dot: 'bg-alert' },
};

// Lightweight date presentation (e.g. "Jun 1"). Adjust the format if you like.
function formatDate(value: string | null): string {
    if (!value) {
        return '—';
    }

    return new Date(value).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
    });
}

// ─────────────────────────────────────────────────────────────────────────────
// Delete flow. `deleteTarget` holds the offer being confirmed (or null =
// dialog closed) — one ref encodes both "which row" and "is the dialog open".
const deleteTarget = ref<OfferListItem | null>(null);

function confirmDelete(offer: OfferListItem) {
    deleteTarget.value = offer;
}

function cancelDelete() {
    deleteTarget.value = null;
}

// router.delete() sends a DELETE visit to the destroy route. The OfferPolicy on
// the backend enforces owner-only (the UI hiding the button is not the guard);
// on success the controller redirects to index and Inertia re-renders without
// the row. onSuccess closes the dialog.
function performDelete() {
    if (!deleteTarget.value) {
        return;
    }

    router.delete(OfferController.destroy(deleteTarget.value.id).url, {
        onSuccess: () => cancelDelete(),
    });
}
</script>
