<template>
    <Head :title="`Order #${order.reference}`" />

    <GrasslyAppLayout :title="`Order #${order.reference}`">
        <template #actions>
            <div class="flex items-center gap-3">
                <Link
                    :href="OrderController.index().url"
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
                    Orders
                </Link>
                <span
                    class="inline-flex items-center gap-1.5 rounded-full px-3 py-[5px] text-xs font-bold"
                    :class="pill.chip"
                >
                    <span
                        class="size-1.5 rounded-full"
                        :class="pill.dot"
                    ></span>
                    {{ pill.label }}
                </span>
            </div>
        </template>

        <div class="flex justify-center p-7">
            <div class="flex w-[820px] max-w-full flex-col gap-6">
                <!-- SUMMARY -->
                <div
                    class="flex items-center gap-5 rounded-[20px] border border-[#E8EAE2] bg-white p-6"
                >
                    <span
                        class="flex size-14 flex-none items-center justify-center rounded-[14px] bg-lime-pale"
                    >
                        <svg
                            width="26"
                            height="26"
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
                    <div class="min-w-0 flex-1">
                        <div
                            class="text-[19px] font-extrabold tracking-[-0.01em]"
                        >
                            {{ order.quantity_display }} · {{ order.item }}
                        </div>
                        <div class="mt-0.5 text-[13px] text-[#6B7260]">
                            {{ order.seller_name }} → {{ order.buyer_name }}
                        </div>
                    </div>
                    <div class="flex-none text-right">
                        <div
                            class="text-[22px] font-extrabold tracking-[-0.02em]"
                        >
                            {{ order.total_formatted }}
                        </div>
                        <div class="text-xs text-[#6B7260]">
                            {{ order.price_formatted }}/{{ order.unit }}
                        </div>
                    </div>
                </div>

                <!-- HORIZONTAL STEP TRACKER -->
                <div
                    class="rounded-[20px] border border-[#E8EAE2] bg-white px-6 py-7"
                >
                    <div v-if="isCancelled" class="text-center">
                        <span
                            class="inline-flex items-center gap-1.5 rounded-full bg-[#FBE4E3] px-3.5 py-1.5 text-[13px] font-bold text-[#B0302F]"
                        >
                            <span class="size-1.5 rounded-full bg-alert"></span>
                            This order was cancelled
                        </span>
                    </div>
                    <div v-else class="flex items-start">
                        <div
                            v-for="(step, i) in steps"
                            :key="step.key"
                            class="relative flex flex-1 flex-col items-center"
                        >
                            <!-- connector lines -->
                            <span
                                v-if="i > 0"
                                class="absolute top-[13px] left-0 h-0.5 w-1/2"
                                :class="
                                    step.lineLeftActive
                                        ? 'bg-lime'
                                        : 'bg-[#E8EAE2]'
                                "
                            ></span>
                            <span
                                v-if="i < steps.length - 1"
                                class="absolute top-[13px] right-0 h-0.5 w-1/2"
                                :class="
                                    step.lineRightActive
                                        ? 'bg-lime'
                                        : 'bg-[#E8EAE2]'
                                "
                            ></span>
                            <!-- node -->
                            <span
                                class="z-[1] flex size-7 flex-none items-center justify-center rounded-full"
                                :class="
                                    step.done
                                        ? 'bg-lime'
                                        : 'border-2 border-[#D4D7CB] bg-white'
                                "
                            >
                                <svg
                                    v-if="step.done"
                                    width="14"
                                    height="14"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#0F1510"
                                    stroke-width="3.2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M5 12 L10 17 L19 7" />
                                </svg>
                            </span>
                            <div
                                class="mt-2.5 text-center text-xs font-bold"
                                :class="
                                    step.done ? 'text-ink' : 'text-[#9AA08E]'
                                "
                            >
                                {{ step.label }}
                            </div>
                            <div
                                v-if="step.time"
                                class="mt-0.5 text-center text-[11px] text-[#9AA08E]"
                            >
                                {{ step.time }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DELIVERY DETAILS -->
                <div
                    class="rounded-[20px] border border-[#E8EAE2] bg-white p-6"
                >
                    <h3
                        class="mb-4 text-[17px] font-extrabold tracking-[-0.01em]"
                    >
                        Delivery details
                    </h3>
                    <div class="grid grid-cols-2 gap-4 max-sm:grid-cols-1">
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
                                <div class="text-xs text-[#6B7260]">Window</div>
                                <div class="text-sm font-bold">
                                    {{ order.delivery_window ?? 'Not set' }}
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
                                    <path
                                        d="M12 21 C12 21 5 14 5 9 a7 7 0 0 1 14 0 c0 5 -7 12 -7 12 Z"
                                    />
                                    <circle cx="12" cy="9" r="2.4" />
                                </svg>
                            </span>
                            <div>
                                <div class="text-xs text-[#6B7260]">
                                    Destination
                                </div>
                                <div class="text-sm font-bold">
                                    {{ order.destination ?? '—' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="order.note"
                        class="mt-4 border-t border-[#E8EAE2] pt-4"
                    >
                        <div class="mb-1.5 text-xs text-[#6B7260]">
                            Note to farmer
                        </div>
                        <div class="text-sm text-ink">{{ order.note }}</div>
                    </div>
                </div>

                <!-- ACTIONS -->
                <div class="flex items-center gap-3.5">
                    <!-- Message farmer — Phase 5 chat, inert for now. -->
                    <button
                        type="button"
                        disabled
                        class="inline-flex cursor-not-allowed items-center gap-2 rounded-xl border border-[#E8EAE2] bg-white px-[22px] py-3.5 text-sm font-bold text-ink opacity-60"
                    >
                        <svg
                            width="15"
                            height="15"
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
                    <button
                        v-if="cancellable"
                        type="button"
                        class="ml-auto inline-flex items-center gap-2 rounded-xl border border-[#F3C9C8] bg-white px-[22px] py-3.5 text-sm font-bold text-alert transition-colors hover:bg-[#FBE4E3]"
                        @click="cancelOrder"
                    >
                        Cancel order
                    </button>
                </div>
            </div>
        </div>
    </GrasslyAppLayout>
</template>

<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import OrderController from '@/actions/App/Http/Controllers/OrderController';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';
import { statusPill } from '@/lib/orderStatus';
import type { OrderStatus } from '@/types/enums';
import type { Order } from '@/types/order';

const props = defineProps<{
    order: Order;
}>();

const pill = computed(() => statusPill(props.order.status));
const isCancelled = computed(() => props.order.status === 'cancelled');

// A claim can be cancelled until it's delivered (or already cancelled). The
// authoritative rule is a backend policy (Milestone A.4) — this only hides the
// button.
const cancellable = computed(
    () =>
        props.order.status !== 'delivered' &&
        props.order.status !== 'cancelled',
);

// The delivery lifecycle, in order (mirrors App\Enums\OrderStatus::lifecycle()).
const LIFECYCLE: { key: OrderStatus; label: string }[] = [
    { key: 'placed', label: 'Placed' },
    { key: 'accepted', label: 'Accepted' },
    { key: 'packing', label: 'Packing' },
    { key: 'in_transit', label: 'In transit' },
    { key: 'delivered', label: 'Delivered' },
];

// Derive the tracker purely from the current status. Presentational only.
const steps = computed(() => {
    const current = LIFECYCLE.findIndex((s) => s.key === props.order.status);

    return LIFECYCLE.map((s, i) => ({
        key: s.key,
        label: s.label,
        done: current >= 0 && i <= current,
        lineLeftActive: current >= 0 && i <= current,
        lineRightActive: current >= 0 && i < current,
        // We only have one real timestamp (placed_at); per-step times would need
        // a status-history table (a later enhancement), so only "Placed" shows one.
        time: s.key === 'placed' ? props.order.placed_at : null,
    }));
});

// TODO(you) [Milestone A.4]: cancel this order. Guard with a policy server-side,
// then router.patch/delete to a cancel route and flip status → cancelled.
// Hint: router.patch(route('orders.cancel', order.id)) once you add that route.
function cancelOrder() {
    // TODO(you)
}
</script>
