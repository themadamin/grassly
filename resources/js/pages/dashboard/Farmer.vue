<template>
    <Head title="Farmer dashboard" />

    <GrasslyAppLayout :title="greeting">
        <!-- Topbar action -->
        <template #actions>
            <button
                type="button"
                class="inline-flex items-center gap-2 rounded-xl bg-lime px-[18px] py-[11px] text-sm font-bold text-ink transition-colors hover:bg-lime-dark"
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
                New listing
            </button>
        </template>

        <div class="flex flex-col gap-7 p-7">
            <!-- STAT ROW -->
            <section class="grid grid-cols-4 gap-5">
                <!-- Storage listed -->
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
                                <path d="M3 9 L12 4 L21 9 V20 H3 Z" />
                                <path d="M9 20 V13 H15 V20" />
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
                            3
                        </span>
                    </div>
                    <div
                        class="mb-1.5 text-xs font-bold tracking-[0.04em] text-[#6B7260] uppercase"
                    >
                        Storage listed
                    </div>
                    <div
                        class="text-[34px] leading-none font-extrabold tracking-[-0.03em]"
                    >
                        12
                    </div>
                </div>

                <!-- Active orders (ink) -->
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
                                8
                            </span>
                        </div>
                        <div
                            class="mb-1.5 text-xs font-bold tracking-[0.04em] text-[#8C9482] uppercase"
                        >
                            Active orders
                        </div>
                        <div
                            class="text-[34px] leading-none font-extrabold tracking-[-0.03em] text-white"
                        >
                            27
                        </div>
                    </div>
                </div>

                <!-- Upcoming harvests (amber) -->
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
                                <path d="M4 18 L9 12 L13 15 L20 6" />
                                <path d="M15 6 H20 V11" />
                            </svg>
                        </span>
                        <span
                            class="rounded-full bg-[#FAEEDA] px-2.5 py-1 text-[11px] font-bold text-[#9A6210]"
                            >Seasonal</span
                        >
                    </div>
                    <div
                        class="mb-1.5 text-xs font-bold tracking-[0.04em] text-[#6B7260] uppercase"
                    >
                        Upcoming harvests
                    </div>
                    <div
                        class="text-[34px] leading-none font-extrabold tracking-[-0.03em]"
                    >
                        5
                    </div>
                </div>

                <!-- On-time delivery -->
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
                                <path d="M5 7 H15 V16 H5 Z" />
                                <path d="M15 10 H19 L21 13 V16 H15 Z" />
                                <circle cx="8" cy="18" r="1.8" />
                                <circle cx="17.5" cy="18" r="1.8" />
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
                            1.2%
                        </span>
                    </div>
                    <div
                        class="mb-1.5 text-xs font-bold tracking-[0.04em] text-[#6B7260] uppercase"
                    >
                        On-time delivery
                    </div>
                    <div
                        class="text-[34px] leading-none font-extrabold tracking-[-0.03em] text-[#7AB82A]"
                    >
                        97.4%
                    </div>
                </div>
            </section>

            <!-- MY STORAGE LISTINGS -->
            <section>
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-[19px] font-extrabold tracking-[-0.01em]">
                        My storage listings
                    </h3>
                    <a
                        href="#"
                        class="text-[13px] font-bold text-[#7AB82A] no-underline"
                        >View all</a
                    >
                </div>
                <div class="grid grid-cols-3 gap-5">
                    <!-- Listing: cold storage -->
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
                                >Cold storage</span
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
                                Riverside Farm · Plot 4
                            </div>
                            <div class="flex items-end justify-between">
                                <div>
                                    <div
                                        class="text-[22px] font-extrabold tracking-[-0.02em]"
                                    >
                                        2.4t
                                    </div>
                                    <div class="text-xs text-[#6B7260]">
                                        available now
                                    </div>
                                </div>
                                <div class="text-base font-bold text-[#7AB82A]">
                                    $3.20<span
                                        class="text-xs font-semibold text-[#6B7260]"
                                        >/kg</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Listing: dry store -->
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
                                >Dry store</span
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
                                Riverside Farm · Silo 2
                            </div>
                            <div class="flex items-end justify-between">
                                <div>
                                    <div
                                        class="text-[22px] font-extrabold tracking-[-0.02em]"
                                    >
                                        18t
                                    </div>
                                    <div class="text-xs text-[#6B7260]">
                                        available now
                                    </div>
                                </div>
                                <div class="text-base font-bold text-[#7AB82A]">
                                    $0.42<span
                                        class="text-xs font-semibold text-[#6B7260]"
                                        >/kg</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Listing: private -->
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
                                >Cold storage</span
                            >
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
                        <div class="p-[18px]">
                            <div class="mb-1 text-[17px] font-bold">
                                Table grapes
                            </div>
                            <div class="mb-3.5 text-[13px] text-[#6B7260]">
                                Riverside Farm · Plot 1
                            </div>
                            <div class="flex items-end justify-between">
                                <div>
                                    <div
                                        class="text-[22px] font-extrabold tracking-[-0.02em]"
                                    >
                                        900kg
                                    </div>
                                    <div class="text-xs text-[#6B7260]">
                                        reserved buyer
                                    </div>
                                </div>
                                <div class="text-base font-bold text-[#7AB82A]">
                                    $5.10<span
                                        class="text-xs font-semibold text-[#6B7260]"
                                        >/kg</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- UPCOMING HARVESTS + RECENT ORDERS -->
            <section class="grid grid-cols-[1.1fr_1fr] gap-7">
                <!-- Upcoming harvests -->
                <div>
                    <h3
                        class="mb-4 text-[19px] font-extrabold tracking-[-0.01em]"
                    >
                        Upcoming harvests
                    </h3>
                    <div class="flex flex-col gap-4">
                        <!-- Aug 14 -->
                        <div
                            class="flex overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                        >
                            <div
                                class="flex w-24 flex-none flex-col items-center justify-center bg-ink text-white"
                                style="
                                    background-image: repeating-radial-gradient(
                                        circle at 70% 30%,
                                        transparent 0 12px,
                                        rgba(168, 230, 61, 0.1) 12px 13.5px
                                    );
                                "
                            >
                                <div
                                    class="text-[13px] font-bold text-[#8C9482]"
                                >
                                    AUG
                                </div>
                                <div
                                    class="text-[30px] leading-none font-extrabold tracking-[-0.03em]"
                                >
                                    14
                                </div>
                            </div>
                            <div class="flex-1 px-[18px] py-4">
                                <div
                                    class="mb-1.5 flex items-center justify-between"
                                >
                                    <div class="text-base font-bold">
                                        Sweet corn
                                    </div>
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-[#FAEEDA] px-2.5 py-1 text-[11px] font-bold text-[#9A6210]"
                                    >
                                        <span
                                            class="size-[5px] rounded-full bg-harvest"
                                        ></span>
                                        Upcoming
                                    </span>
                                </div>
                                <div class="mb-2.5 text-[13px] text-[#6B7260]">
                                    Est. yield 6.5t · 3 buyers watching
                                </div>
                                <div
                                    class="h-1.5 overflow-hidden rounded-full bg-stone"
                                >
                                    <div
                                        class="h-full bg-harvest"
                                        style="width: 68%"
                                    ></div>
                                </div>
                            </div>
                        </div>

                        <!-- Sep 02 -->
                        <div
                            class="flex overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                        >
                            <div
                                class="flex w-24 flex-none flex-col items-center justify-center bg-ink text-white"
                                style="
                                    background-image: repeating-radial-gradient(
                                        circle at 70% 30%,
                                        transparent 0 12px,
                                        rgba(168, 230, 61, 0.1) 12px 13.5px
                                    );
                                "
                            >
                                <div
                                    class="text-[13px] font-bold text-[#8C9482]"
                                >
                                    SEP
                                </div>
                                <div
                                    class="text-[30px] leading-none font-extrabold tracking-[-0.03em]"
                                >
                                    02
                                </div>
                            </div>
                            <div class="flex-1 px-[18px] py-4">
                                <div
                                    class="mb-1.5 flex items-center justify-between"
                                >
                                    <div class="text-base font-bold">
                                        Butternut squash
                                    </div>
                                    <span
                                        class="inline-flex items-center gap-1.5 rounded-full bg-[#FAEEDA] px-2.5 py-1 text-[11px] font-bold text-[#9A6210]"
                                    >
                                        <span
                                            class="size-[5px] rounded-full bg-harvest"
                                        ></span>
                                        Upcoming
                                    </span>
                                </div>
                                <div class="mb-2.5 text-[13px] text-[#6B7260]">
                                    Est. yield 4.0t · 1 buyer watching
                                </div>
                                <div
                                    class="h-1.5 overflow-hidden rounded-full bg-stone"
                                >
                                    <div
                                        class="h-full bg-harvest"
                                        style="width: 34%"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent orders -->
                <div>
                    <h3
                        class="mb-4 text-[19px] font-extrabold tracking-[-0.01em]"
                    >
                        Recent orders
                    </h3>
                    <div
                        class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                    >
                        <div
                            class="flex items-center gap-3.5 border-b border-[#E8EAE2] px-[18px] py-[15px]"
                        >
                            <span
                                class="flex size-9 flex-none items-center justify-center rounded-[10px] bg-stone text-[13px] font-extrabold"
                                >VG</span
                            >
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-bold">
                                    Verdi Grocers
                                </div>
                                <div class="text-xs text-[#6B7260]">
                                    800kg maize · #GR-2841
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-lime-pale px-2.5 py-1 text-[11px] font-bold text-[#3F5610]"
                            >
                                <span
                                    class="size-[5px] rounded-full bg-[#7AB82A]"
                                ></span>
                                Available
                            </span>
                        </div>
                        <div
                            class="flex items-center gap-3.5 border-b border-[#E8EAE2] px-[18px] py-[15px]"
                        >
                            <span
                                class="flex size-9 flex-none items-center justify-center rounded-[10px] bg-stone text-[13px] font-extrabold"
                                >FC</span
                            >
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-bold">Fresh Co.</div>
                                <div class="text-xs text-[#6B7260]">
                                    300kg tomatoes · #GR-2838
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
                                >MM</span
                            >
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-bold">
                                    Metro Market
                                </div>
                                <div class="text-xs text-[#6B7260]">
                                    1.2t maize · #GR-2835
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-[#FAEEDA] px-2.5 py-1 text-[11px] font-bold text-[#9A6210]"
                            >
                                <span
                                    class="size-[5px] rounded-full bg-harvest"
                                ></span>
                                Upcoming
                            </span>
                        </div>
                        <div
                            class="flex items-center gap-3.5 px-[18px] py-[15px]"
                        >
                            <span
                                class="flex size-9 flex-none items-center justify-center rounded-[10px] bg-stone text-[13px] font-extrabold"
                                >OL</span
                            >
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-bold">
                                    Olive Lane Deli
                                </div>
                                <div class="text-xs text-[#6B7260]">
                                    120kg grapes · #GR-2829
                                </div>
                            </div>
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-[#FBE4E3] px-2.5 py-1 text-[11px] font-bold text-[#B0302F]"
                            >
                                <span
                                    class="size-[5px] rounded-full bg-alert"
                                ></span>
                                Closed
                            </span>
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
// Claude Design handoff. When the Phase 3 models exist (StorageListing,
// HarvestForecast, Order), a controller will pass real data as Inertia props
// and these blocks become v-for loops over typed arrays.
// TODO(you): define the prop interfaces and `defineProps<FarmerDashboardProps>()`
// then replace the hard-coded markup with bound data.
</script>
