<template>
    <Head title="Merchant dashboard" />

    <GrasslyAppLayout :title="greeting">
        <!-- Topbar action -->
        <template #actions>
            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-xl bg-ink px-[18px] py-[11px] text-sm font-bold text-white transition-colors hover:bg-ink/90"
            >
                <svg
                    width="15"
                    height="15"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="#A8E63D"
                    stroke-width="2.4"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <circle cx="11" cy="11" r="7" />
                    <path d="M21 21 L16.5 16.5" />
                </svg>
                Browse market
            </button>
        </template>

        <div class="flex flex-col gap-7 p-7">
            <!-- STAT ROW -->
            <section class="grid grid-cols-4 gap-5">
                <!-- Active orders -->
                <div
                    class="rounded-[20px] border border-[#E8EAE2] bg-white p-[22px]"
                >
                    <div class="mb-5 flex items-center justify-between">
                        <span
                            class="flex size-10 items-center justify-center rounded-xl bg-stone"
                        >
                            <svg
                                width="19"
                                height="19"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#0F1510"
                                stroke-width="2.1"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <rect
                                    x="4"
                                    y="4"
                                    width="16"
                                    height="16"
                                    rx="2.5"
                                />
                                <path d="M8 9 H16" />
                                <path d="M8 13 H16" />
                            </svg>
                        </span>
                        <span
                            class="inline-flex items-center gap-1 rounded-full bg-lime-pale px-2.5 py-1 text-[11px] font-bold text-[#3F5610]"
                        >
                            <svg
                                width="10"
                                height="10"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#7AB82A"
                                stroke-width="3"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M6 14 L12 8 L18 14" />
                            </svg>
                            4
                        </span>
                    </div>
                    <div
                        class="mb-1.5 text-xs font-bold tracking-[0.04em] text-[#6B7260] uppercase"
                    >
                        Active orders
                    </div>
                    <div
                        class="text-[34px] leading-none font-extrabold tracking-[-0.03em]"
                    >
                        19
                    </div>
                </div>

                <!-- In-transit -->
                <div
                    class="rounded-[20px] border border-[#E8EAE2] bg-white p-[22px]"
                >
                    <div class="mb-5 flex items-center justify-between">
                        <span
                            class="flex size-10 items-center justify-center rounded-xl bg-[#FAEEDA]"
                        >
                            <svg
                                width="19"
                                height="19"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#EF9F27"
                                stroke-width="2.1"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M5 7 H15 V16 H5 Z" />
                                <path d="M15 10 H19 L21 13 V16 H15 Z" />
                                <circle cx="8" cy="18" r="1.8" />
                                <circle cx="17.5" cy="18" r="1.8" />
                            </svg>
                        </span>
                        <span
                            class="rounded-full bg-[#FAEEDA] px-2.5 py-1 text-[11px] font-bold text-[#9A6210]"
                            >Live</span
                        >
                    </div>
                    <div
                        class="mb-1.5 text-xs font-bold tracking-[0.04em] text-[#6B7260] uppercase"
                    >
                        In-transit
                    </div>
                    <div
                        class="text-[34px] leading-none font-extrabold tracking-[-0.03em]"
                    >
                        6
                    </div>
                </div>

                <!-- Saved farmers -->
                <div
                    class="rounded-[20px] border border-[#E8EAE2] bg-white p-[22px]"
                >
                    <div class="mb-5 flex items-center justify-between">
                        <span
                            class="flex size-10 items-center justify-center rounded-xl bg-lime-pale"
                        >
                            <svg
                                width="19"
                                height="19"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#5C8A1A"
                                stroke-width="2.1"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    d="M12 20 C12 20 4 15 4 9 a4 4 0 0 1 8 -1 a4 4 0 0 1 8 1 c0 6 -8 11 -8 11 Z"
                                />
                            </svg>
                        </span>
                        <span
                            class="inline-flex items-center gap-1 rounded-full bg-lime-pale px-2.5 py-1 text-[11px] font-bold text-[#3F5610]"
                        >
                            <svg
                                width="10"
                                height="10"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="#7AB82A"
                                stroke-width="3"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path d="M6 14 L12 8 L18 14" />
                            </svg>
                            2
                        </span>
                    </div>
                    <div
                        class="mb-1.5 text-xs font-bold tracking-[0.04em] text-[#6B7260] uppercase"
                    >
                        Saved farmers
                    </div>
                    <div
                        class="text-[34px] leading-none font-extrabold tracking-[-0.03em]"
                    >
                        23
                    </div>
                </div>

                <!-- Spend (ink) -->
                <div
                    class="relative overflow-hidden rounded-[20px] border border-ink bg-ink p-[22px]"
                >
                    <div
                        class="pointer-events-none absolute inset-0"
                        style="
                            background-image: repeating-radial-gradient(
                                circle at 88% 12%,
                                transparent 0 15px,
                                rgba(168, 230, 61, 0.07) 15px 16.5px
                            );
                        "
                    ></div>
                    <div class="relative">
                        <div class="mb-5 flex items-center justify-between">
                            <span
                                class="flex size-10 items-center justify-center rounded-xl bg-lime"
                            >
                                <svg
                                    width="19"
                                    height="19"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#0F1510"
                                    stroke-width="2.1"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M12 3 V21" />
                                    <path
                                        d="M17 7 H9.5 a3.5 3.5 0 0 0 0 7 h5 a3.5 3.5 0 0 1 0 7 H6"
                                    />
                                </svg>
                            </span>
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-lime/15 px-2.5 py-1 text-[11px] font-bold text-lime"
                            >
                                <svg
                                    width="10"
                                    height="10"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#A8E63D"
                                    stroke-width="3"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M6 14 L12 8 L18 14" />
                                </svg>
                                11%
                            </span>
                        </div>
                        <div
                            class="mb-1.5 text-xs font-bold tracking-[0.04em] text-[#8C9482] uppercase"
                        >
                            Spend · season
                        </div>
                        <div
                            class="text-[34px] leading-none font-extrabold tracking-[-0.03em] text-white"
                        >
                            $142k
                        </div>
                    </div>
                </div>
            </section>

            <!-- BROWSE THE MARKET -->
            <section>
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-[19px] font-extrabold tracking-[-0.01em]">
                        Browse the market
                    </h3>
                    <a
                        href="#"
                        class="text-[13px] font-bold text-[#7AB82A] no-underline"
                        >See all listings</a
                    >
                </div>
                <div class="grid grid-cols-3 gap-5">
                    <!-- Produce (available) -->
                    <div
                        class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                    >
                        <div
                            class="relative flex h-21 items-start justify-between bg-lime p-4"
                            style="
                                background-image: repeating-radial-gradient(
                                    circle at 85% 25%,
                                    transparent 0 13px,
                                    rgba(15, 21, 16, 0.07) 13px 14.5px
                                );
                            "
                        >
                            <span
                                class="text-[13px] font-extrabold tracking-[0.1em] text-[#3F5610] uppercase"
                                >Produce</span
                            >
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-ink px-2.5 py-1 text-[11px] font-bold text-white"
                            >
                                <span
                                    class="size-[5px] rounded-full bg-lime"
                                ></span>
                                Available
                            </span>
                        </div>
                        <div class="p-[18px]">
                            <div class="mb-1 text-[17px] font-bold">
                                Heirloom tomatoes
                            </div>
                            <div class="mb-3.5 text-[13px] text-[#6B7260]">
                                Riverside Farm · 40km
                            </div>
                            <div class="flex items-end justify-between">
                                <div>
                                    <div
                                        class="text-[22px] font-extrabold tracking-[-0.02em]"
                                    >
                                        2.4t
                                    </div>
                                    <div class="text-xs text-[#6B7260]">
                                        available
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    class="rounded-[10px] border border-[#E8EAE2] bg-stone px-3.5 py-2 text-[13px] font-bold text-ink"
                                >
                                    Order
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Forecast (upcoming, ink header) -->
                    <div
                        class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                    >
                        <div
                            class="relative flex h-21 items-start justify-between bg-ink p-4"
                            style="
                                background-image: repeating-radial-gradient(
                                    circle at 85% 25%,
                                    transparent 0 13px,
                                    rgba(168, 230, 61, 0.1) 13px 14.5px
                                );
                            "
                        >
                            <span
                                class="text-[13px] font-extrabold tracking-[0.1em] text-[#8C9482] uppercase"
                                >Forecast</span
                            >
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-[#FAEEDA] px-2.5 py-1 text-[11px] font-bold text-[#9A6210]"
                            >
                                <span
                                    class="size-[5px] rounded-full bg-harvest"
                                ></span>
                                Upcoming
                            </span>
                        </div>
                        <div class="p-[18px]">
                            <div class="mb-1 text-[17px] font-bold">
                                Sweet corn
                            </div>
                            <div class="mb-3.5 text-[13px] text-[#6B7260]">
                                Hill Crest · ready Aug 14
                            </div>
                            <div class="flex items-end justify-between">
                                <div>
                                    <div
                                        class="text-[22px] font-extrabold tracking-[-0.02em]"
                                    >
                                        6.5t
                                    </div>
                                    <div class="text-xs text-[#6B7260]">
                                        est. yield
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    class="rounded-[10px] border border-[#E8EAE2] bg-stone px-3.5 py-2 text-[13px] font-bold text-ink"
                                >
                                    Pre-book
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Grain (available) -->
                    <div
                        class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                    >
                        <div
                            class="relative flex h-21 items-start justify-between bg-lime p-4"
                            style="
                                background-image: repeating-radial-gradient(
                                    circle at 85% 25%,
                                    transparent 0 13px,
                                    rgba(15, 21, 16, 0.07) 13px 14.5px
                                );
                            "
                        >
                            <span
                                class="text-[13px] font-extrabold tracking-[0.1em] text-[#3F5610] uppercase"
                                >Grain</span
                            >
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-ink px-2.5 py-1 text-[11px] font-bold text-white"
                            >
                                <span
                                    class="size-[5px] rounded-full bg-lime"
                                ></span>
                                Available
                            </span>
                        </div>
                        <div class="p-[18px]">
                            <div class="mb-1 text-[17px] font-bold">
                                Maize, grade A
                            </div>
                            <div class="mb-3.5 text-[13px] text-[#6B7260]">
                                Riverside Farm · 40km
                            </div>
                            <div class="flex items-end justify-between">
                                <div>
                                    <div
                                        class="text-[22px] font-extrabold tracking-[-0.02em]"
                                    >
                                        18t
                                    </div>
                                    <div class="text-xs text-[#6B7260]">
                                        available
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    class="rounded-[10px] border border-[#E8EAE2] bg-stone px-3.5 py-2 text-[13px] font-bold text-ink"
                                >
                                    Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- MY ORDERS + TRACKING -->
            <section class="grid grid-cols-[1fr_0.9fr] gap-7">
                <!-- My orders -->
                <div>
                    <h3
                        class="mb-4 text-[19px] font-extrabold tracking-[-0.01em]"
                    >
                        My orders
                    </h3>
                    <div
                        class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                    >
                        <div
                            class="flex items-center gap-3.5 border-b border-[#E8EAE2] px-[18px] py-[15px]"
                        >
                            <span
                                class="flex size-9 flex-none items-center justify-center rounded-[10px] bg-stone text-[13px] font-extrabold"
                                >RF</span
                            >
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-bold">
                                    Riverside Farm
                                </div>
                                <div class="text-xs text-[#6B7260]">
                                    800kg maize · #OR-5512
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-[#FAEEDA] px-2.5 py-1 text-[11px] font-bold text-[#9A6210]"
                            >
                                <span
                                    class="size-[5px] rounded-full bg-harvest"
                                ></span>
                                In transit
                            </span>
                        </div>
                        <div
                            class="flex items-center gap-3.5 border-b border-[#E8EAE2] px-[18px] py-[15px]"
                        >
                            <span
                                class="flex size-9 flex-none items-center justify-center rounded-[10px] bg-stone text-[13px] font-extrabold"
                                >HC</span
                            >
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-bold">Hill Crest</div>
                                <div class="text-xs text-[#6B7260]">
                                    300kg tomatoes · #OR-5508
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-ink px-2.5 py-1 text-[11px] font-bold text-white"
                            >
                                <svg
                                    width="11"
                                    height="11"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#A8E63D"
                                    stroke-width="2.6"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <rect
                                        x="5"
                                        y="11"
                                        width="14"
                                        height="9"
                                        rx="2"
                                    />
                                    <path d="M8 11 V8 a4 4 0 0 1 8 0 v3" />
                                </svg>
                                Private
                            </span>
                        </div>
                        <div
                            class="flex items-center gap-3.5 border-b border-[#E8EAE2] px-[18px] py-[15px]"
                        >
                            <span
                                class="flex size-9 flex-none items-center justify-center rounded-[10px] bg-stone text-[13px] font-extrabold"
                                >GV</span
                            >
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-bold">
                                    Green Valley
                                </div>
                                <div class="text-xs text-[#6B7260]">
                                    1.2t squash · #OR-5499
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-lime-pale px-2.5 py-1 text-[11px] font-bold text-[#3F5610]"
                            >
                                <svg
                                    width="11"
                                    height="11"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#7AB82A"
                                    stroke-width="3"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M5 12 L10 17 L19 7" />
                                </svg>
                                Delivered
                            </span>
                        </div>
                        <div
                            class="flex items-center gap-3.5 px-[18px] py-[15px]"
                        >
                            <span
                                class="flex size-9 flex-none items-center justify-center rounded-[10px] bg-stone text-[13px] font-extrabold"
                                >RF</span
                            >
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-bold">
                                    Riverside Farm
                                </div>
                                <div class="text-xs text-[#6B7260]">
                                    500kg grapes · #OR-5481
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-lime-pale px-2.5 py-1 text-[11px] font-bold text-[#3F5610]"
                            >
                                <svg
                                    width="11"
                                    height="11"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#7AB82A"
                                    stroke-width="3"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M5 12 L10 17 L19 7" />
                                </svg>
                                Delivered
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Tracking -->
                <div>
                    <h3
                        class="mb-4 text-[19px] font-extrabold tracking-[-0.01em]"
                    >
                        Tracking
                    </h3>
                    <div
                        class="rounded-[20px] border border-[#E8EAE2] bg-white p-[22px]"
                    >
                        <div
                            class="mb-[18px] flex items-center justify-between"
                        >
                            <div>
                                <div class="text-[15px] font-bold">
                                    Order #OR-5512
                                </div>
                                <div class="text-[13px] text-[#6B7260]">
                                    800kg maize · Riverside Farm
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-[#FAEEDA] px-3 py-[5px] text-xs font-bold text-[#9A6210]"
                            >
                                <span
                                    class="size-1.5 rounded-full bg-harvest"
                                ></span>
                                In transit
                            </span>
                        </div>

                        <div
                            class="mb-5 flex items-center justify-between rounded-[14px] border border-[#E8EAE2] bg-stone p-4"
                        >
                            <div>
                                <div class="mb-0.5 text-xs text-[#6B7260]">
                                    Arriving
                                </div>
                                <div class="text-[17px] font-extrabold">
                                    Today, 4:30 PM
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="mb-0.5 text-xs text-[#6B7260]">
                                    Distance left
                                </div>
                                <div
                                    class="text-[17px] font-extrabold text-[#7AB82A]"
                                >
                                    12 km
                                </div>
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="flex flex-col">
                            <div class="flex gap-3.5">
                                <div class="flex flex-col items-center">
                                    <span
                                        class="flex size-[18px] items-center justify-center rounded-full bg-lime"
                                    >
                                        <svg
                                            width="11"
                                            height="11"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#0F1510"
                                            stroke-width="3.4"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path d="M5 12 L10 17 L19 7" />
                                        </svg>
                                    </span>
                                    <span
                                        class="min-h-[22px] w-0.5 flex-1 bg-lime"
                                    ></span>
                                </div>
                                <div class="pb-[18px]">
                                    <div class="text-sm font-bold">
                                        Picked up
                                    </div>
                                    <div class="text-xs text-[#6B7260]">
                                        Riverside Farm · 11:05 AM
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-3.5">
                                <div class="flex flex-col items-center">
                                    <span
                                        class="flex size-[18px] items-center justify-center rounded-full bg-lime"
                                    >
                                        <svg
                                            width="11"
                                            height="11"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="#0F1510"
                                            stroke-width="3.4"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path d="M5 12 L10 17 L19 7" />
                                        </svg>
                                    </span>
                                    <span
                                        class="min-h-[22px] w-0.5 flex-1 bg-[#E8EAE2]"
                                    ></span>
                                </div>
                                <div class="pb-[18px]">
                                    <div class="text-sm font-bold">
                                        In transit
                                    </div>
                                    <div class="text-xs text-[#6B7260]">
                                        Hwy 9 depot · 2:48 PM
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-3.5">
                                <div class="flex flex-col items-center">
                                    <span
                                        class="size-[18px] rounded-full border-2 border-[#D4D7CB] bg-white"
                                    ></span>
                                </div>
                                <div>
                                    <div
                                        class="text-sm font-bold text-[#9AA08E]"
                                    >
                                        Delivered
                                    </div>
                                    <div class="text-xs text-[#9AA08E]">
                                        Your warehouse · ETA 4:30 PM
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </GrasslyAppLayout>
</template>

<script setup lang="ts">
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';

const page = usePage();

const greeting = computed(() => {
    return `Welcome back, ${page.props.auth.user.name.split(' ')[0]}`;
});
// NOTE: every figure/card below is static placeholder content matching the
// Claude Design handoff. When the Phase 3 models exist (Order, StorageListing,
// HarvestForecast, delivery tracking), a controller will pass real data as
// Inertia props and these blocks become v-for loops over typed arrays.
// TODO(you): define the prop interfaces and `defineProps<MerchantDashboardProps>()`
// then replace the hard-coded markup with bound data.
</script>
