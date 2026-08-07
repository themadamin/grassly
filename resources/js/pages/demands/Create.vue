<template>
    <Head title="New demand" />

    <GrasslyAppLayout title="New demand">
        <template #actions>
            <Link
                :href="DemandController.index().url"
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
                Demands
            </Link>
        </template>

        <div class="p-7">
            <div class="max-w-[640px]">
                <div
                    class="rounded-[20px] border border-[#E8EAE2] bg-white p-6"
                >
                    <!-- What -->
                    <div class="mb-4">
                        <label class="mb-1.5 block text-[13px] font-bold"
                            >What are you looking for?</label
                        >
                        <input
                            placeholder="e.g. Dragon fruit, weekly supply"
                            class="w-full rounded-xl border border-[#E8EAE2] bg-white px-[15px] py-3 text-[15px] font-medium text-ink outline-none placeholder:text-[#9AA08E]"
                        />
                    </div>

                    <!-- Category + region -->
                    <div
                        class="mb-4 grid grid-cols-2 gap-3.5 max-sm:grid-cols-1"
                    >
                        <div>
                            <label class="mb-1.5 block text-[13px] font-bold"
                                >Crop / category</label
                            >
                            <div class="relative">
                                <select
                                    class="w-full cursor-pointer appearance-none rounded-xl border border-[#E8EAE2] bg-white py-3 pr-9 pl-3.5 text-sm font-medium text-ink outline-none"
                                >
                                    <option>Fruit</option>
                                    <option>Produce</option>
                                    <option>Grain</option>
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
                        <div>
                            <label class="mb-1.5 block text-[13px] font-bold"
                                >Region wanted</label
                            >
                            <div class="relative">
                                <select
                                    class="w-full cursor-pointer appearance-none rounded-xl border border-[#E8EAE2] bg-white py-3 pr-9 pl-3.5 text-sm font-medium text-ink outline-none"
                                >
                                    <option>Any region</option>
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
                        </div>
                    </div>

                    <!-- Quantity + price -->
                    <div
                        class="mb-4 grid grid-cols-2 gap-3.5 max-sm:grid-cols-1"
                    >
                        <div>
                            <label class="mb-1.5 block text-[13px] font-bold"
                                >Quantity needed</label
                            >
                            <div class="relative">
                                <input
                                    placeholder="0"
                                    class="w-full rounded-xl border border-[#E8EAE2] bg-white py-3 pr-8 pl-3.5 text-sm font-medium text-ink outline-none"
                                />
                                <span
                                    class="absolute top-1/2 right-3.5 -translate-y-1/2 text-[13px] font-bold text-[#6B7260]"
                                    >t</span
                                >
                            </div>
                        </div>
                        <div>
                            <label class="mb-1.5 block text-[13px] font-bold"
                                >Target price</label
                            >
                            <div class="relative">
                                <span
                                    class="absolute top-1/2 left-3.5 -translate-y-1/2 text-sm font-bold text-[#6B7260]"
                                    >$</span
                                >
                                <input
                                    placeholder="0.00"
                                    class="w-full rounded-xl border border-[#E8EAE2] bg-white py-3 pr-3.5 pl-7 text-sm font-medium text-ink outline-none"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Needed by -->
                    <div class="mb-4">
                        <label class="mb-1.5 block text-[13px] font-bold"
                            >Needed by</label
                        >
                        <input
                            type="date"
                            class="w-full rounded-xl border border-[#E8EAE2] bg-white px-3.5 py-3 text-sm font-medium text-ink outline-none"
                        />
                    </div>

                    <!-- Note -->
                    <div>
                        <label
                            class="mb-1.5 flex items-center gap-1.5 text-[13px] font-bold"
                        >
                            Note for farmers
                            <span
                                class="text-[11px] font-semibold text-[#9AA08E]"
                                >optional</span
                            >
                        </label>
                        <textarea
                            rows="2"
                            placeholder="Grading, packaging, delivery terms…"
                            class="w-full resize-none rounded-xl border border-[#E8EAE2] bg-white px-3.5 py-3 text-sm leading-normal font-medium text-ink outline-none"
                        ></textarea>
                    </div>
                </div>

                <div class="mt-[18px] flex items-center gap-3">
                    <!-- Amber = the buy side (mirror of the lime sell side). -->
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 rounded-xl bg-[#EF9F27] px-[22px] py-3.5 text-sm font-bold text-ink transition-colors hover:brightness-95"
                        @click="submit"
                    >
                        <svg
                            width="15"
                            height="15"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#0F1510"
                            stroke-width="2.4"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M12 5 V19" />
                            <path d="M5 12 H19" />
                        </svg>
                        Publish demand
                    </button>
                    <Link
                        :href="DemandController.index().url"
                        class="text-[13px] font-bold text-[#6B7260] no-underline"
                    >
                        Cancel
                    </Link>
                </div>
            </div>
        </div>
    </GrasslyAppLayout>
</template>

<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import DemandController from '@/actions/App/Http/Controllers/DemandController';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';

// ─────────────────────────────────────────────────────────────────────────────
// YOUR LEARNING SURFACE — the demand form (Feature B). This mirrors the Offer
// create form you already built.
//
// TODO(you): add a typed Inertia useForm for { title, category, region,
// quantity, price, needed_by, note }, v-model each field above, then post to
// DemandController.store() on submit (handle validation errors). Price is entered
// in major units; the backend MoneyCast converts to minor units.
//   Concept: useForm<T>() — define an interface for the form shape first.

function submit() {
    // TODO(you): form.post(DemandController.store().url, { ... })
}
</script>
