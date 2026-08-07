<template>
    <Head title="My demands" />

    <GrasslyAppLayout title="My demands">
        <template #actions>
            <Link
                :href="DemandController.create().url"
                class="inline-flex items-center gap-2 rounded-xl bg-[#EF9F27] px-[18px] py-[11px] text-sm font-bold text-ink no-underline transition-colors hover:brightness-95"
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
                New demand
            </Link>
        </template>

        <!-- EMPTY STATE -->
        <div
            v-if="demands.length === 0"
            class="flex min-h-[560px] items-center justify-center p-7"
        >
            <div class="max-w-[420px] text-center">
                <div
                    class="mx-auto mb-6 flex size-[88px] items-center justify-center rounded-[22px] border border-[#E8EAE2] bg-[#FAEEDA]"
                >
                    <svg
                        width="38"
                        height="38"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="#9A6210"
                        stroke-width="1.9"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M4 7 H18 L17 15 H6 Z" />
                        <path d="M6 15 L5 4 H3" />
                        <circle cx="8" cy="19" r="1.4" />
                        <circle cx="16" cy="19" r="1.4" />
                    </svg>
                </div>
                <h2
                    class="mb-2.5 text-[26px] font-extrabold tracking-[-0.02em]"
                >
                    No demands yet
                </h2>
                <p
                    class="mx-auto mb-6 max-w-[340px] text-[15px] leading-relaxed text-[#6B7260]"
                >
                    Post what you need to buy and let farmers come to you. Your
                    demands appear on the Market's Buying tab.
                </p>
                <Link
                    :href="DemandController.create().url"
                    class="inline-flex items-center gap-2.5 rounded-xl bg-[#EF9F27] px-[26px] py-3.5 text-[15px] font-bold text-ink no-underline transition-colors hover:brightness-95"
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
                    Post your first demand
                </Link>
            </div>
        </div>

        <!-- GRID -->
        <div v-else class="p-7">
            <div class="mb-4 text-sm font-bold">
                {{ demands.length }}
                {{ demands.length === 1 ? 'demand' : 'demands' }}
            </div>
            <div
                class="grid grid-cols-[repeat(auto-fill,minmax(290px,1fr))] gap-5"
            >
                <article
                    v-for="demand in demands"
                    :key="demand.id"
                    class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                >
                    <div
                        class="flex h-[62px] items-center justify-between bg-[#FAEEDA] px-[18px]"
                    >
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-ink px-[11px] py-1 text-[11px] font-extrabold tracking-[0.08em] text-[#EF9F27] uppercase"
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
                        <span
                            class="text-xs font-extrabold tracking-[0.1em] text-[#9A6210] uppercase"
                        >
                            {{ demand.category }}
                        </span>
                    </div>
                    <div class="p-[18px]">
                        <div
                            class="mb-0.5 text-[18px] font-extrabold tracking-[-0.01em]"
                        >
                            {{ demand.title }}
                        </div>
                        <div class="mb-[14px] text-[13px] text-[#6B7260]">
                            {{ demand.region }}
                        </div>
                        <div class="mb-3 flex items-end justify-between">
                            <div
                                class="text-[24px] font-extrabold tracking-[-0.03em] text-[#9A6210]"
                            >
                                {{ demand.price_formatted
                                }}<span
                                    class="text-[13px] font-semibold text-[#6B7260]"
                                    >/{{ demand.unit }}</span
                                >
                            </div>
                            <div class="text-[13px] font-bold text-[#6B7260]">
                                {{ demand.quantity_display }}
                            </div>
                        </div>
                        <div class="mb-4">
                            <div
                                class="mb-1.5 h-1.5 overflow-hidden rounded-full bg-stone"
                            >
                                <div
                                    class="h-full rounded-full bg-[#EF9F27]"
                                    :style="{
                                        width: `${demand.progress_percent}%`,
                                    }"
                                ></div>
                            </div>
                            <div class="text-xs text-[#6B7260]">
                                {{ demand.progress_percent }}% fulfilled
                            </div>
                        </div>
                        <Link
                            :href="DemandController.show(demand.id).url"
                            class="block w-full rounded-[10px] border border-[#E8EAE2] bg-white py-[11px] text-center text-[13px] font-bold text-ink no-underline transition-colors hover:bg-stone"
                        >
                            View demand
                        </Link>
                    </div>
                </article>
            </div>
        </div>
    </GrasslyAppLayout>
</template>

<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import DemandController from '@/actions/App/Http/Controllers/DemandController';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';
import type { DemandListItem } from '@/types/demand';

withDefaults(
    defineProps<{
        demands?: DemandListItem[];
    }>(),
    {
        demands: () => [],
    },
);
</script>
