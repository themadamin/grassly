<template>
    <Head title="Orders" />

    <GrasslyAppLayout title="Orders">
        <div class="p-7">
            <!-- STATUS TABS -->
            <div
                class="mb-[22px] inline-flex gap-1 rounded-[14px] border border-[#E8EAE2] bg-white p-[5px]"
            >
                <button
                    v-for="t in tabs"
                    :key="t.key"
                    type="button"
                    :class="tabClass(t.key)"
                    @click="setTab(t.key)"
                >
                    {{ t.label }}
                </button>
            </div>

            <!-- TABLE -->
            <div
                class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
            >
                <!-- Header row -->
                <div
                    class="grid grid-cols-[110px_1.6fr_1fr_100px_130px_40px] gap-3 border-b border-[#E8EAE2] bg-stone px-[22px] py-3.5 text-[11px] font-extrabold tracking-[0.08em] text-[#8A9180] uppercase"
                >
                    <div>Order</div>
                    <div>Item</div>
                    <div>Counterparty</div>
                    <div>Qty</div>
                    <div>Status</div>
                    <div></div>
                </div>

                <!-- Rows -->
                <Link
                    v-for="order in orders"
                    :key="order.id"
                    :href="OrderController.show(order.id).url"
                    class="grid grid-cols-[110px_1.6fr_1fr_100px_130px_40px] items-center gap-3 border-b border-[#E8EAE2] px-[22px] py-4 no-underline transition-colors last:border-b-0 hover:bg-stone"
                >
                    <div class="text-[13px] font-bold text-[#6B7260]">
                        #{{ order.reference }}
                    </div>
                    <div class="text-sm font-bold text-ink">
                        {{ order.item }}
                    </div>
                    <div class="text-sm text-ink">{{ order.counterparty }}</div>
                    <div class="text-sm font-bold text-ink">
                        {{ order.quantity_display }}
                    </div>
                    <div>
                        <span
                            class="inline-flex w-max items-center gap-[5px] rounded-full px-3 py-[5px] text-xs font-bold"
                            :class="statusPill(order.status).chip"
                        >
                            <span
                                class="size-1.5 rounded-full"
                                :class="statusPill(order.status).dot"
                            ></span>
                            {{ statusPill(order.status).label }}
                        </span>
                    </div>
                    <svg
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="#9AA08E"
                        stroke-width="2.2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M9 6 L15 12 L9 18" />
                    </svg>
                </Link>

                <!-- Empty state -->
                <div
                    v-if="orders.length === 0"
                    class="flex flex-col items-center justify-center px-6 py-20 text-center"
                >
                    <div
                        class="mb-4 flex size-[72px] items-center justify-center rounded-[20px] border border-[#E8EAE2] bg-stone"
                    >
                        <svg
                            width="30"
                            height="30"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#9AA08E"
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
                    <div class="text-[17px] font-extrabold">No orders here</div>
                    <p class="mt-1.5 max-w-[320px] text-sm text-[#6B7260]">
                        {{ emptyMessage }}
                    </p>
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
import type { OrderListItem } from '@/types/order';

// Status tab. Server-driven, mirroring the Market page (the controller filters,
// not the browser).
type OrdersTab = 'all' | 'in_transit' | 'delivered' | 'cancelled';

const props = withDefaults(
    defineProps<{
        orders?: OrderListItem[];
        tab?: OrdersTab;
    }>(),
    {
        orders: () => [],
        tab: 'all',
    },
);

const tabs: { key: OrdersTab; label: string }[] = [
    { key: 'all', label: 'All' },
    { key: 'in_transit', label: 'In transit' },
    { key: 'delivered', label: 'Delivered' },
    { key: 'cancelled', label: 'Cancelled' },
];

function tabClass(key: OrdersTab): string {
    const base =
        'cursor-pointer whitespace-nowrap rounded-[10px] px-5 py-[9px] text-sm font-bold transition-colors';

    return key === props.tab
        ? `${base} bg-lime text-ink`
        : `${base} bg-transparent text-[#6B7260] hover:text-ink`;
}

const emptyMessage = computed(() =>
    props.tab === 'all'
        ? 'Claims placed against offers show up here once orders exist.'
        : `No ${props.tab.replace('_', ' ')} orders right now.`,
);

// TODO(you) [Milestone A.3]: switch tabs server-side, like the Market page.
// Hint: router.get(OrderController.index().url, { tab }, { preserveScroll: true,
//   only: ['orders', 'tab'] }). `OrderController` is imported above.
function setTab(tab: OrdersTab) {
    void tab; // remove once implemented
    // TODO(you)
}
</script>
