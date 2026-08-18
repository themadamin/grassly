<template>
    <!--
      Controlled dialog (v-model:open from the parent, like ConfirmDialog).
      The offer being claimed is passed in; the merchant picks a quantity
      (capped at remaining), an optional delivery window + note, and confirms.
      Instant claim — no approval (see CLAUDE.md → Claim model).
    -->
    <Dialog :open="open" @update:open="$emit('update:open', $event)">
        <DialogContent
            :show-close-button="false"
            class="w-[460px] gap-0 overflow-hidden rounded-[20px] border-[#E8EAE2] bg-white p-0"
        >
            <!-- Lime header band -->
            <div
                class="relative px-6 py-5"
                style="
                    background-color: #a8e63d;
                    background-image: repeating-radial-gradient(
                        circle at 85% 30%,
                        transparent 0 12px,
                        rgba(15, 21, 16, 0.07) 12px 13.5px
                    );
                "
            >
                <div
                    class="mb-1 text-xs font-extrabold tracking-[0.12em] text-[#3F5610] uppercase"
                >
                    Claim from offer
                </div>
                <DialogTitle
                    class="text-xl font-extrabold tracking-[-0.02em] text-ink"
                >
                    {{ offer.title }}
                </DialogTitle>
                <DialogDescription class="mt-0.5 text-[13px] text-[#3F5610]">
                    {{ offer.farmer?.name ?? 'Farmer' }} ·
                    {{ offer.regions.map((r) => r.name).join(', ') }}
                </DialogDescription>
            </div>

            <div class="p-6">
                <!-- Price + remaining -->
                <div
                    class="mb-5 flex items-center justify-between rounded-[14px] border border-[#E8EAE2] bg-stone px-4 py-3.5"
                >
                    <div>
                        <div class="mb-0.5 text-xs text-[#6B7260]">
                            Fixed price
                        </div>
                        <div class="text-lg font-extrabold text-[#7AB82A]">
                            {{ offer.price_formatted
                            }}<span class="text-xs font-semibold text-[#6B7260]"
                                >/{{ offer.unit }}</span
                            >
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="mb-0.5 text-xs text-[#6B7260]">
                            Remaining
                        </div>
                        <div class="text-lg font-extrabold">
                            {{ offer.remaining_display }}
                        </div>
                    </div>
                </div>

                <!-- QUANTITY STEPPER -->
                <div class="mb-[18px]">
                    <label class="mb-2 block text-[13px] font-bold"
                        >Quantity to claim</label
                    >
                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            class="size-11 flex-none rounded-xl border border-[#E8EAE2] bg-stone text-xl font-extrabold text-ink"
                            aria-label="Decrease quantity"
                            @click="decQty"
                        >
                            –
                        </button>
                        <div class="flex-1 text-center">
                            <span
                                class="text-[28px] font-extrabold tracking-[-0.02em]"
                                >{{ qty }}</span
                            >
                            <span
                                class="text-[15px] font-semibold text-[#6B7260]"
                            >
                                {{ offer.unit }}</span
                            >
                        </div>
                        <button
                            type="button"
                            class="size-11 flex-none rounded-xl border border-[#E8EAE2] bg-stone text-xl font-extrabold text-ink"
                            aria-label="Increase quantity"
                            @click="incQty"
                        >
                            +
                        </button>
                    </div>
                    <div
                        class="mt-3 h-1.5 overflow-hidden rounded-full bg-stone"
                    >
                        <div
                            class="h-full rounded-full bg-lime"
                            :style="{ width: qtyBarWidth }"
                        ></div>
                    </div>
                    <div class="mt-1.5 text-xs text-[#6B7260]">
                        Capped at {{ offer.remaining_display }} remaining on
                        this offer.
                    </div>
                </div>

                <!-- DELIVERY WINDOW -->
                <div class="mb-[18px]">
                    <label class="mb-1.5 block text-[13px] font-bold"
                        >Delivery window</label
                    >
                    <div class="relative">
                        <select
                            v-model="deliveryWindow"
                            class="w-full cursor-pointer appearance-none rounded-xl border border-[#E8EAE2] bg-white py-3 pr-10 pl-[15px] text-[15px] font-medium text-ink outline-none"
                        >
                            <option>This week</option>
                            <option>Next week</option>
                            <option>Choose a date…</option>
                        </select>
                        <svg
                            class="pointer-events-none absolute top-1/2 right-3.5 -translate-y-1/2"
                            width="16"
                            height="16"
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

                <!-- NOTE -->
                <div class="mb-5">
                    <label
                        class="mb-1.5 flex items-center gap-1.5 text-[13px] font-bold"
                    >
                        Note to farmer
                        <span class="text-[11px] font-semibold text-[#9AA08E]"
                            >optional</span
                        >
                    </label>
                    <textarea
                        v-model="note"
                        rows="2"
                        placeholder="Delivery instructions, packaging preferences…"
                        class="w-full resize-none rounded-xl border border-[#E8EAE2] bg-white px-3.5 py-3 text-sm leading-normal font-medium text-ink outline-none"
                    ></textarea>
                </div>

                <!-- TOTAL -->
                <div
                    class="mb-5 flex items-center justify-between border-t border-[#E8EAE2] pt-4"
                >
                    <span class="text-sm font-bold text-[#6B7260]"
                        >Order total</span
                    >
                    <span class="text-2xl font-extrabold tracking-[-0.02em]">{{
                        orderTotalPreview
                    }}</span>
                </div>

                <button
                    type="button"
                    class="mb-2.5 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-lime py-3.5 text-[15px] font-bold text-ink transition-colors hover:bg-lime-dark"
                    @click="submitClaim"
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
                        <path d="M4 12 L10 18 L20 6" />
                    </svg>
                    Confirm order
                </button>
                <div class="mb-1.5 text-center text-xs text-[#8A9180]">
                    Instant claim — no approval needed. Quantity reserves
                    immediately.
                </div>
                <DialogClose as-child>
                    <button
                        type="button"
                        class="block w-full text-center text-sm font-bold text-[#6B7260]"
                    >
                        Cancel
                    </button>
                </DialogClose>
            </div>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogTitle,
} from '@/components/ui/dialog';
import type { Offer } from '@/types/offer';

// The offer being claimed (full detail DTO). `open` is controlled by the parent
// via v-model:open.
defineProps<{
    open: boolean;
    offer: Offer;
}>();

defineEmits<{
    'update:open': [value: boolean];
}>();

// ─────────────────────────────────────────────────────────────────────────────
// YOUR LEARNING SURFACE — the claim form (Milestone A.2). The template wires the
// stepper buttons, the v-models, the total and the confirm button to the
// state/handlers below; you make them real.
//
// Suggested approach: an Inertia useForm holds { offer_id, quantity,
// delivery_window, note }. The stepper mutates form.quantity (clamped between
// one step and the offer's remaining_quantity). submitClaim posts to
// OrderController.store(). The SERVER re-checks the cap inside a DB transaction
// (never trust the client) and decrements remaining_quantity.

// Standalone refs for now — fold these into a typed useForm when you wire submit.
const qty = ref<number>(0); // TODO(you): initialise from the unit step, e.g. 1
const deliveryWindow = ref<string>('This week');
const note = ref<string>('');

// TODO(you): step the quantity DOWN by one unit, not below the minimum.
// Hint: qty.value = Math.max(step, +(qty.value - step).toFixed(1))
function decQty() {
    // TODO(you)
}

// TODO(you): step UP by one unit, capped at offer.remaining_quantity.
// Hint: qty.value = Math.min(props.offer.remaining_quantity, qty.value + step)
function incQty() {
    // TODO(you)
}

// TODO(you): progress fill = claimed share of the offer's remaining quantity.
// Return a CSS width string like `${(qty / remaining) * 100}%`.
const qtyBarWidth = ref<string>('0%');

// TODO(you): a CLIENT-SIDE preview of qty × price. The authoritative total is
// computed server-side from the snapshot price (formatting lives in PHP), so
// treat this as a preview only. Hint: Intl.NumberFormat for the currency.
const orderTotalPreview = ref<string>('—');

// TODO(you) [Milestone A.2]: post the claim.
// Hint: form.post(OrderController.store().url, { onSuccess: () => emit('update:open', false) })
//   Import OrderController from '@/actions/App/Http/Controllers/OrderController'.
function submitClaim() {
    // TODO(you)
}
</script>
