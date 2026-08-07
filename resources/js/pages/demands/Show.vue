<template>
    <Head :title="demand.title" />

    <GrasslyAppLayout title="Demand detail">
        <template #actions>
            <Link
                :href="market().url"
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
                Market
            </Link>
        </template>

        <div class="p-7">
            <div class="flex max-w-[640px] flex-col gap-[18px]">
                <!-- AMBER HERO + PROGRESS -->
                <div
                    class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                >
                    <div
                        class="flex items-start justify-between bg-[#FAEEDA] p-5"
                    >
                        <div>
                            <span
                                class="mb-2.5 inline-flex items-center gap-1.5 rounded-full bg-ink px-[11px] py-1 text-[11px] font-extrabold tracking-[0.08em] text-[#EF9F27] uppercase"
                            >
                                <svg
                                    width="11"
                                    height="11"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#EF9F27"
                                    stroke-width="3"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M4 7 H18 L17 15 H6 Z" />
                                </svg>
                                Buying
                            </span>
                            <h2
                                class="text-2xl font-extrabold tracking-[-0.02em]"
                            >
                                {{ demand.title }}
                            </h2>
                            <div class="mt-0.5 text-[13px] text-[#9A6210]">
                                {{ demand.merchant_name }} · {{ demand.region }}
                            </div>
                        </div>
                        <div class="flex-none text-right">
                            <div class="text-xl font-extrabold text-[#9A6210]">
                                {{ demand.price_formatted
                                }}<span class="text-xs font-semibold"
                                    >/{{ demand.unit }}</span
                                >
                            </div>
                        </div>
                    </div>
                    <div class="p-5">
                        <div class="mb-2.5 flex items-end justify-between">
                            <span class="text-[13px] font-bold"
                                >{{ demand.fulfilled_display }} fulfilled of
                                {{ demand.quantity_display }}</span
                            >
                            <span class="text-[13px] font-bold text-[#9A6210]"
                                >{{ demand.progress_percent }}%</span
                            >
                        </div>
                        <div class="h-2 overflow-hidden rounded-full bg-stone">
                            <div
                                class="h-full rounded-full bg-[#EF9F27]"
                                :style="{
                                    width: `${demand.progress_percent}%`,
                                }"
                            ></div>
                        </div>
                    </div>
                </div>

                <!-- FARMER CLAIMS -->
                <div
                    class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                >
                    <div class="border-b border-[#E8EAE2] px-5 py-3.5">
                        <h3 class="text-[15px] font-extrabold">
                            Farmer claims
                        </h3>
                    </div>
                    <div
                        v-for="claim in demand.claims"
                        :key="claim.id"
                        class="flex items-center gap-3 border-b border-[#E8EAE2] px-5 py-3.5 last:border-b-0"
                    >
                        <span
                            class="flex size-[34px] flex-none items-center justify-center rounded-[10px] bg-stone text-xs font-extrabold"
                        >
                            {{ getInitials(claim.counterparty) }}
                        </span>
                        <div class="min-w-0 flex-1">
                            <div class="text-[13px] font-bold">
                                {{ claim.counterparty }}
                            </div>
                            <div class="text-[11px] text-[#6B7260]">
                                {{ claim.quantity_display }} · placed
                                {{ claim.placed_at }}
                            </div>
                        </div>
                        <span
                            class="inline-flex items-center gap-[5px] rounded-full px-2.5 py-1 text-[11px] font-bold"
                            :class="statusPill(claim.status).chip"
                        >
                            {{ statusPill(claim.status).label }}
                        </span>
                    </div>
                    <div
                        v-if="demand.claims.length === 0"
                        class="px-5 py-8 text-center text-sm text-[#6B7260]"
                    >
                        No farmer claims yet.
                    </div>
                </div>

                <!-- Farmers claim against a demand (symmetric with a merchant
                     claiming an offer). Feature B — inert stub for now. -->
                <button
                    type="button"
                    class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-ink py-3.5 text-sm font-bold text-[#EF9F27] transition-colors hover:bg-ink/90"
                    @click="claimAgainstDemand"
                >
                    <svg
                        width="15"
                        height="15"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="#EF9F27"
                        stroke-width="2.4"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M4 7 H18 L17 15 H6 Z" />
                        <path d="M6 15 L5 4 H3" />
                    </svg>
                    Claim against this demand
                </button>
            </div>
        </div>
    </GrasslyAppLayout>
</template>

<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { useInitials } from '@/composables/useInitials';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';
import { statusPill } from '@/lib/orderStatus';
import { market } from '@/routes';
import type { Demand } from '@/types/demand';

defineProps<{
    demand: Demand;
}>();

const { getInitials } = useInitials();

// TODO(you) [Feature B]: a farmer claims part of this demand — the symmetric
// mirror of a merchant claiming an offer. Reuse the claim flow (a modal like
// ClaimOrderModal, but posting a farmer-side claim). Inert until that backend
// exists.
function claimAgainstDemand() {
    // TODO(you)
}
</script>
