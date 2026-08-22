<template>
    <article
        class="flex h-full flex-col overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
    >
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

        <div class="flex flex-1 flex-col p-[18px]">
            <div class="mb-2.5 text-lg font-extrabold tracking-[-0.01em]">
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
                    {{ offer.regions.map((r) => r.name).join(', ') }}
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
                        <rect x="4" y="5" width="16" height="16" rx="2.5" />
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

            <div class="mt-auto mb-4 flex items-end justify-between">
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
                <button
                    type="button"
                    class="flex size-10 flex-none items-center justify-center rounded-[10px] border border-[#E8EAE2] bg-white transition-colors hover:bg-stone"
                    aria-label="Delete offer"
                    @click="$emit('delete', offer)"
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
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import OfferController from '@/actions/App/Http/Controllers/OfferController';
import type { OfferListItem } from '@/types/offer';

defineProps<{
    offer: OfferListItem;
}>();

defineEmits<{
    delete: [offer: OfferListItem];
}>();

const statusStyles: Record<string, { chip: string; dot: string }> = {
    on_sale: { chip: 'bg-lime-pale text-[#3F5610]', dot: 'bg-[#7AB82A]' },
    draft: { chip: 'bg-[#E8EAE2] text-[#5A6150]', dot: 'bg-[#9AA08E]' },
    closed: { chip: 'bg-[#FBE4E3] text-[#B0302F]', dot: 'bg-alert' },
};

function formatDate(value: string | null): string {
    if (!value) {
        return '—';
    }

    return new Date(value).toLocaleDateString('en-US', {
        month: 'short',
        day: 'numeric',
    });
}
</script>
