<template>
    <Head title="Edit offer" />

    <GrasslyAppLayout title="Edit offer">
        <div class="mx-auto w-full max-w-3xl p-7">
            <!-- Back to offers -->
            <Link
                :href="OfferController.index()"
                class="mb-5 inline-flex items-center gap-2 text-[13px] font-bold text-[#6B7260] no-underline transition-colors hover:text-ink"
            >
                <svg
                    width="15"
                    height="15"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2.4"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                >
                    <path d="M15 6 L9 12 L15 18" />
                </svg>
                All offers
            </Link>

            <form
                class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                @submit.prevent="submit"
            >
                <!-- Lime header band -->
                <div
                    class="relative flex items-center justify-between bg-lime px-7 py-5"
                    style="
                        background-image: repeating-radial-gradient(
                            circle at 90% 25%,
                            transparent 0 13px,
                            rgba(15, 21, 16, 0.07) 13px 14.5px
                        );
                    "
                >
                    <div>
                        <div
                            class="text-[11px] font-extrabold tracking-[0.12em] text-[#3F5610] uppercase"
                        >
                            Sell offer
                        </div>
                        <div class="text-[19px] font-extrabold text-ink">
                            Update your offer
                        </div>
                    </div>
                    <span
                        class="flex size-11 items-center justify-center rounded-xl bg-ink"
                    >
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#A8E63D"
                            stroke-width="2.2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M20 4 H13 L3 14 L10 21 L20 11 Z" />
                            <circle cx="16.5" cy="7.5" r="1.3" />
                        </svg>
                    </span>
                </div>

                <div class="flex flex-col gap-7 p-7">
                    <!-- DETAILS -->
                    <section class="flex flex-col gap-4">
                        <h3
                            class="text-xs font-bold tracking-[0.04em] text-[#6B7260] uppercase"
                        >
                            Details
                        </h3>

                        <div>
                            <Label for="product_id" :class="labelClass"
                                >Product</Label
                            >
                            <select
                                id="product_id"
                                v-model.number="form.product_id"
                                :class="fieldClass"
                            >
                                <option :value="null" disabled>
                                    Select a product…
                                </option>
                                <option
                                    v-for="product in products"
                                    :key="product.id"
                                    :value="product.id"
                                >
                                    {{ product.name }}
                                </option>
                            </select>
                            <InputError :message="form.errors.product_id" />
                        </div>

                        <div>
                            <Label for="title" :class="labelClass"
                                >Offer title</Label
                            >
                            <Input
                                id="title"
                                v-model="form.title"
                                type="text"
                                placeholder="Fresh heirloom tomatoes"
                                :class="fieldClass"
                            />
                            <InputError :message="form.errors.title" />
                        </div>

                        <div>
                            <Label for="region" :class="labelClass"
                                >Region</Label
                            >
                            <Input
                                id="region"
                                v-model="form.region"
                                type="text"
                                placeholder="Riverside"
                                :class="fieldClass"
                            />
                            <InputError :message="form.errors.region" />
                        </div>
                    </section>

                    <Separator class="bg-[#E8EAE2]" />

                    <!-- QUANTITY & PRICE -->
                    <section class="flex flex-col gap-4">
                        <h3
                            class="text-xs font-bold tracking-[0.04em] text-[#6B7260] uppercase"
                        >
                            Quantity &amp; price
                        </h3>

                        <div class="grid grid-cols-[2fr_1fr] gap-4">
                            <div>
                                <Label for="total_quantity" :class="labelClass"
                                    >Total quantity</Label
                                >
                                <!-- Native input so the model can be null (blank). -->
                                <input
                                    id="total_quantity"
                                    v-model.number="form.total_quantity"
                                    type="number"
                                    min="1"
                                    step="1"
                                    placeholder="2400"
                                    :class="fieldClass"
                                />
                                <InputError
                                    :message="form.errors.total_quantity"
                                />
                            </div>
                            <div>
                                <Label for="unit" :class="labelClass"
                                    >Unit</Label
                                >
                                <select
                                    id="unit"
                                    v-model="form.unit"
                                    :class="fieldClass"
                                >
                                    <option value="kg">kg</option>
                                    <option value="ton">ton</option>
                                </select>
                                <InputError :message="form.errors.unit" />
                            </div>
                        </div>

                        <div>
                            <Label for="price" :class="labelClass"
                                >Price
                                <span class="font-normal text-[#9CA395]"
                                    >(per {{ form.unit }})</span
                                ></Label
                            >
                            <!-- Prefilled from offer.price (already decimal dollars
                                 from MoneyCast); masked + grouped by MoneyInput. -->
                            <MoneyInput
                                id="price"
                                v-model="form.price"
                                :max="PRICE_MAX"
                                :class="fieldClass"
                            />
                            <InputError :message="form.errors.price" />
                        </div>
                    </section>

                    <Separator class="bg-[#E8EAE2]" />

                    <!-- AVAILABILITY -->
                    <section class="flex flex-col gap-4">
                        <h3
                            class="text-xs font-bold tracking-[0.04em] text-[#6B7260] uppercase"
                        >
                            Availability
                        </h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <Label for="available_from" :class="labelClass"
                                    >Available from</Label
                                >
                                <Input
                                    id="available_from"
                                    v-model="form.available_from"
                                    type="date"
                                    :class="fieldClass"
                                />
                                <InputError
                                    :message="form.errors.available_from"
                                />
                            </div>
                            <div>
                                <Label for="available_to" :class="labelClass"
                                    >Available to
                                    <span class="text-[#9CA395]"
                                        >(optional)</span
                                    ></Label
                                >
                                <Input
                                    id="available_to"
                                    v-model="form.available_to"
                                    type="date"
                                    :class="fieldClass"
                                />
                                <InputError
                                    :message="form.errors.available_to"
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <Label for="visibility" :class="labelClass"
                                    >Visibility</Label
                                >
                                <select
                                    id="visibility"
                                    v-model="form.visibility"
                                    :class="fieldClass"
                                >
                                    <option
                                        v-for="(label, value) in visibilities"
                                        :key="value"
                                        :value="value"
                                    >
                                        {{ label }}
                                    </option>
                                </select>
                                <InputError :message="form.errors.visibility" />
                            </div>
                            <div>
                                <Label for="status" :class="labelClass"
                                    >Status</Label
                                >
                                <select
                                    id="status"
                                    v-model="form.status"
                                    :class="fieldClass"
                                >
                                    <option
                                        v-for="(label, value) in statuses"
                                        :key="value"
                                        :value="value"
                                        class="capitalize"
                                    >
                                        {{ label }}
                                    </option>
                                </select>
                                <InputError :message="form.errors.status" />
                            </div>
                        </div>
                    </section>

                    <Separator class="bg-[#E8EAE2]" />

                    <!-- DESCRIPTION -->
                    <section>
                        <Label for="description" :class="labelClass"
                            >Description
                            <span class="text-[#9CA395]"
                                >(optional)</span
                            ></Label
                        >
                        <textarea
                            id="description"
                            v-model="form.description"
                            rows="4"
                            placeholder="Conditions, access, handling notes…"
                            :class="[fieldClass, 'resize-none']"
                        ></textarea>
                        <InputError :message="form.errors.description" />
                    </section>

                    <!-- ACTIONS -->
                    <div
                        class="flex items-center justify-end gap-3 border-t border-[#E8EAE2] pt-6"
                    >
                        <Link
                            :href="OfferController.index().url"
                            class="rounded-xl px-5 py-3 text-sm font-bold text-[#6B7260] no-underline transition-colors hover:text-ink"
                        >
                            Cancel
                        </Link>
                        <Button
                            type="submit"
                            :disabled="form.processing"
                            class="h-auto rounded-xl bg-lime px-6 py-3.5 text-sm font-bold text-ink hover:bg-lime-dark"
                        >
                            <Spinner v-if="form.processing" />
                            Save changes
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </GrasslyAppLayout>
</template>

<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import OfferController from '@/actions/App/Http/Controllers/OfferController';
import MoneyInput from '@/components/grassly/MoneyInput.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Separator } from '@/components/ui/separator';
import { Spinner } from '@/components/ui/spinner';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';
import type { Offer } from '@/types/offer';
import type { ProductListItem } from '@/types/product';

const labelClass = 'mb-1.5 block text-[13px] font-bold';
const fieldClass =
    'h-auto w-full rounded-xl border border-[#E8EAE2] bg-white px-4 py-3.5 text-[15px] font-medium text-ink transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] dark:bg-white';

const props = defineProps<{
    offer: Offer;
    statuses: Record<string, string>;
    visibilities: Record<string, string>;
    products: ProductListItem[];
}>();

interface OfferForm {
    product_id: number | null;
    title: string;
    region: string;
    total_quantity: number | null;
    unit: string;
    // Major units (dollars); null when blank. Backend converts to minor units.
    price: number | null;
    visibility: string;
    available_from: string;
    available_to: string;
    description: string | null;
    status: string;
}

const PRICE_MAX = 9999.99;

// Seed the form from the offer. `offer.product.id` is the current product;
// `offer.price` is already the decimal dollars value (MoneyCast), bound directly.
const form = useForm<OfferForm>({
    product_id: props.offer.product.id,
    title: props.offer.title,
    region: props.offer.region,
    total_quantity: props.offer.total_quantity,
    unit: props.offer.unit,
    price: props.offer.price,
    visibility: props.offer.visibility,
    available_from: props.offer.available_from,
    available_to: props.offer.available_to ?? '',
    description: props.offer.description ?? '',
    status: props.offer.status,
});

// Submit as an UPDATE (HTTP PUT).
function submit() {
    form.put(OfferController.update(props.offer.id).url);
}
</script>
