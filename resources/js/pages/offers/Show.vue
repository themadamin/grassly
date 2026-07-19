<template>
    <Head :title="offer.title" />

    <GrasslyAppLayout title="Listing detail">
        <!-- Breadcrumb back to index -->
        <template #actions>
            <Link
                :href="OfferController.index().url"
                class="inline-flex items-center gap-1.5 text-[13px] font-bold text-[#6B7260] no-underline transition-colors hover:text-ink"
            >
                <svg
                    width="16"
                    height="16"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.4"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M15 6 L9 12 L15 18" />
                </svg>
                Back to listings
            </Link>
        </template>

        <div class="p-7">
            <div
                class="grid grid-cols-[1fr_340px] items-start gap-6 max-lg:grid-cols-1"
            >
                <!-- LEFT: detail -->
                <div class="flex flex-col gap-6">
                    <!-- HERO CARD -->
                    <div
                        class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                    >
                        <div
                            class="relative flex items-start justify-between p-6"
                            style="
                                min-height: 150px;
                                background-color: #a8e63d;
                                background-image: repeating-radial-gradient(
                                    circle at 82% 24%,
                                    transparent 0 16px,
                                    rgba(15, 21, 16, 0.07) 16px 17.5px
                                );
                            "
                        >
                            <div>
                                <div
                                    class="mb-2 text-xs font-extrabold tracking-[0.13em] text-[#3F5610] uppercase"
                                >
                                    {{ offer.product.name }}
                                </div>
                                <h1
                                    class="text-[34px] font-extrabold tracking-[-0.025em] text-ink"
                                >
                                    {{ offer.title }}
                                </h1>
                            </div>
                            <span
                                class="inline-flex flex-none items-center gap-[7px] rounded-full bg-ink px-[15px] py-[7px] text-[13px] font-bold text-white capitalize"
                            >
                                <span
                                    class="size-[7px] rounded-full"
                                    :class="statusStyles[offer.status]?.dot"
                                ></span>
                                {{ offer.status }}
                            </span>
                        </div>
                        <div class="grid grid-cols-3 gap-5 p-6">
                            <div>
                                <div
                                    class="mb-1.5 text-xs font-bold tracking-[0.04em] text-[#6B7260] uppercase"
                                >
                                    Available
                                </div>
                                <div
                                    class="text-2xl font-extrabold tracking-[-0.02em]"
                                >
                                    {{ offer.remaining_display }}
                                    <span class="text-[15px] text-[#6B7260]"
                                        >of {{ offer.total_display }}</span
                                    >
                                </div>
                            </div>
                            <div>
                                <div
                                    class="mb-1.5 text-xs font-bold tracking-[0.04em] text-[#6B7260] uppercase"
                                >
                                    Region
                                </div>
                                <div class="text-lg font-bold">
                                    {{ offer.region }}
                                </div>
                            </div>
                            <div>
                                <div
                                    class="mb-1.5 text-xs font-bold tracking-[0.04em] text-[#6B7260] uppercase"
                                >
                                    Price
                                </div>
                                <div class="text-lg font-bold text-[#7AB82A]">
                                    {{ offer.price_formatted }}
                                    <span
                                        class="text-[13px] font-semibold text-[#6B7260]"
                                        >/ {{ offer.unit }}</span
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Fulfilment progress: how much of total_quantity is
                             still available (remaining decrements via orders in
                             Phase 4). -->
                        <div class="px-6 pb-6">
                            <div
                                class="mb-1.5 flex items-center justify-between text-xs font-bold text-[#6B7260]"
                            >
                                <span>{{ soldPercent }}% claimed</span>
                                <span>{{ offer.remaining_display }} left</span>
                            </div>
                            <div
                                class="h-2.5 w-full overflow-hidden rounded-full bg-[#E8EAE2]"
                            >
                                <div
                                    class="h-full rounded-full bg-lime transition-[width]"
                                    :style="{ width: remainingPercent + '%' }"
                                ></div>
                            </div>
                        </div>
                    </div>

                    <!-- DESCRIPTION -->
                    <div
                        class="rounded-[20px] border border-[#E8EAE2] bg-white p-6"
                    >
                        <h3
                            class="mb-3 text-lg font-extrabold tracking-[-0.01em]"
                        >
                            About this listing
                        </h3>
                        <p
                            class="mb-[18px] text-[15px] leading-relaxed text-[#4A5142]"
                        >
                            {{
                                offer.description ?? 'No description provided.'
                            }}
                        </p>
                        <div
                            class="grid grid-cols-2 gap-3.5 max-sm:grid-cols-1"
                        >
                            <div
                                class="flex items-center gap-3 rounded-[14px] border border-[#E8EAE2] bg-stone p-3.5"
                            >
                                <span
                                    class="flex size-[38px] flex-none items-center justify-center rounded-[11px] border border-[#E8EAE2] bg-white"
                                >
                                    <svg
                                        width="18"
                                        height="18"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="#0F1510"
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
                                </span>
                                <div>
                                    <div class="text-xs text-[#6B7260]">
                                        Availability
                                    </div>
                                    <div class="text-sm font-bold">
                                        {{ formatDate(offer.available_from) }}
                                        –
                                        {{
                                            offer.available_to
                                                ? formatDate(offer.available_to)
                                                : 'open'
                                        }}
                                    </div>
                                </div>
                            </div>
                            <div
                                class="flex items-center gap-3 rounded-[14px] border border-[#E8EAE2] bg-stone p-3.5"
                            >
                                <span
                                    class="flex size-[38px] flex-none items-center justify-center rounded-[11px] border border-[#E8EAE2] bg-white"
                                >
                                    <svg
                                        width="18"
                                        height="18"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="#0F1510"
                                        stroke-width="2.2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path d="M3 9 L12 4 L21 9 V20 H3 Z" />
                                        <path d="M9 20 V13 H15 V20" />
                                    </svg>
                                </span>
                                <div>
                                    <div class="text-xs text-[#6B7260]">
                                        Product
                                    </div>
                                    <div class="text-sm font-bold">
                                        {{ offer.product.name }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FARMER INFO -->
                    <div
                        class="flex items-center gap-4 rounded-[20px] border border-[#E8EAE2] bg-white p-6"
                    >
                        <span
                            class="flex size-[54px] flex-none items-center justify-center rounded-[14px] bg-ink text-lg font-extrabold text-lime"
                        >
                            {{ getInitials(offer.farmer?.name ?? '') }}
                        </span>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="text-[17px] font-extrabold">{{
                                    offer.farmer?.name ?? 'Unknown farmer'
                                }}</span>
                            </div>
                            <div class="mt-0.5 text-[13px] text-[#6B7260]">
                                {{ offer.region }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: action panel (owner vs viewer) -->
                <div class="flex flex-col gap-[18px]">
                    <!-- OWNER (farmer) — shown when the viewer owns this listing.
                         NOTE: this is UX only; the real guard is the backend
                         policy in Milestone 1.4. -->
                    <div
                        v-if="isOwner"
                        class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                    >
                        <div
                            class="bg-ink px-[18px] py-2.5 text-[11px] font-extrabold tracking-[0.13em] text-lime uppercase"
                        >
                            Owner · farmer
                        </div>
                        <div class="p-[22px]">
                            <div
                                class="mb-4 text-sm leading-normal text-[#6B7260]"
                            >
                                This is your listing.
                            </div>
                            <Link
                                :href="OfferController.edit(offer.id).url"
                                class="mb-2.5 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-ink py-3.5 text-[15px] font-bold text-white no-underline transition-colors hover:bg-ink/90"
                            >
                                <svg
                                    width="16"
                                    height="16"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#A8E63D"
                                    stroke-width="2.2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M4 20 H8 L18 10 L14 6 L4 16 Z" />
                                    <path d="M13 7 L17 11" />
                                </svg>
                                Edit listing
                            </Link>
                            <!-- Opens the confirm dialog; the actual delete runs
                                 on the dialog's @confirm (deleteListing). -->
                            <button
                                type="button"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-[#F3C9C8] bg-white py-3.5 text-[15px] font-bold text-alert transition-colors hover:bg-[#FBE4E3]"
                                @click="showDeleteDialog = true"
                            >
                                <svg
                                    width="16"
                                    height="16"
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
                                Delete listing
                            </button>
                        </div>
                    </div>

                    <!-- VIEWER (merchant) — shown to non-owners. The order/chat
                         actions belong to Phase 4/5, so they're inert for now. -->
                    <div
                        v-else
                        class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                    >
                        <div
                            class="border-b border-[#E8EAE2] bg-stone px-[18px] py-2.5 text-[11px] font-extrabold tracking-[0.13em] text-[#8A9180] uppercase"
                        >
                            Viewer · merchant
                        </div>
                        <div class="p-[22px]">
                            <div class="mb-1 flex items-end justify-between">
                                <span class="text-[13px] text-[#6B7260]"
                                    >From</span
                                >
                                <span
                                    class="text-[28px] font-extrabold tracking-[-0.03em] text-[#7AB82A]"
                                    >{{ offer.price_formatted
                                    }}<span
                                        class="text-sm font-semibold text-[#6B7260]"
                                        >/ {{ offer.unit }}</span
                                    ></span
                                >
                            </div>
                            <div class="mb-[18px] text-[13px] text-[#6B7260]">
                                {{ offer.remaining_display }} available ·
                                {{ offer.region }}
                            </div>
                            <!-- "Place order" (Phase 4) + "Message farmer"
                                 (Phase 5) — inert placeholders until those
                                 features exist. -->
                            <button
                                type="button"
                                disabled
                                class="mb-2.5 inline-flex w-full cursor-not-allowed items-center justify-center gap-2 rounded-xl bg-lime py-3.5 text-[15px] font-bold text-ink opacity-60"
                            >
                                <svg
                                    width="16"
                                    height="16"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#0F1510"
                                    stroke-width="2.4"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M4 7 H18 L17 15 H6 Z" />
                                    <path d="M6 15 L5 4 H3" />
                                    <circle cx="8" cy="19" r="1.4" />
                                    <circle cx="16" cy="19" r="1.4" />
                                </svg>
                                Place order
                            </button>
                            <button
                                type="button"
                                disabled
                                class="inline-flex w-full cursor-not-allowed items-center justify-center gap-2 rounded-xl border border-[#E8EAE2] bg-white py-3.5 text-[15px] font-bold text-ink opacity-60"
                            >
                                <svg
                                    width="16"
                                    height="16"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#0F1510"
                                    stroke-width="2.2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M4 5 H20 V16 H12 L8 20 V16 H4 Z" />
                                </svg>
                                Message farmer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete confirmation. Boolean-controlled via v-model:open; @confirm
             runs the existing deleteListing (router.delete → redirect to index). -->
        <ConfirmDialog
            v-model:open="showDeleteDialog"
            title="Delete this listing?"
            :description="`This permanently removes “${offer.title}” and any pending order requests tied to it. This can't be undone.`"
            confirm-label="Delete listing"
            variant="danger"
            @confirm="deleteListing"
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
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import OfferController from '@/actions/App/Http/Controllers/OfferController';
import ConfirmDialog from '@/components/grassly/ConfirmDialog.vue';
import { useInitials } from '@/composables/useInitials';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';

// Typed with the backend-generated DTO. App.Data.OfferData is a GLOBAL ambient
// type (from resources/js/types/generated.d.ts) — no import needed. It already
// nests `farmer` (App.Data.UserData) and exposes `user_id`, so the farmer panel
// and the isOwner check below stay fully typed. The controller's show() loads
// the farmer relation so OfferData can map it.
const props = defineProps<{
    offer: App.Data.OfferData;
}>();

const page = usePage();
const { getInitials } = useInitials();

// Status dot colours (presentational), keyed by OfferStatus value.
const statusStyles: Record<string, { dot: string }> = {
    on_sale: { dot: 'bg-lime' },
    draft: { dot: 'bg-[#9AA08E]' },
    closed: { dot: 'bg-alert' },
};

function formatDate(value: string | null): string {
    if (!value) {
        return '—';
    }

    return new Date(value).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
    });
}

// Which action panel to show. Client-side UX only — the authoritative
// owner-only guard is the backend policy you write in Milestone 1.4.
const isOwner = computed(
    () => page.props.auth.user?.id === props.offer.user_id,
);

// Fulfilment progress bar: percentage of total_quantity still available.
const remainingPercent = computed(() =>
    props.offer.total_quantity > 0
        ? Math.round(
              (props.offer.remaining_quantity / props.offer.total_quantity) *
                  100,
          )
        : 0,
);
const soldPercent = computed(() => 100 - remainingPercent.value);

// Only one offer on this page, so a boolean is enough for the confirm dialog
// (no need for the "object = which row" trick the index list uses).
const showDeleteDialog = ref(false);

function deleteListing() {
    router.delete(OfferController.destroy(props.offer.id).url);
}
</script>
