<template>
    <Head title="New product" />

    <GrasslyAppLayout title="New product">
        <div class="mx-auto w-full max-w-3xl p-7">
            <Link
                :href="ProductController.index()"
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
                All products
            </Link>

            <form
                class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                @submit.prevent="submit"
            >
                <div class="relative flex items-center justify-between bg-lime px-7 py-5">
                    <div>
                        <div
                            class="text-[11px] font-extrabold tracking-[0.12em] text-[#3F5610] uppercase"
                        >
                            Product
                        </div>
                        <div class="text-[19px] font-extrabold text-ink">
                            Add an item to your storage
                        </div>
                    </div>
                    <span class="flex size-11 items-center justify-center rounded-xl bg-ink">
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
                            <path d="M3 9 L12 4 L21 9 V20 H3 Z" />
                            <path d="M9 20 V13 H15 V20" />
                        </svg>
                    </span>
                </div>

                <div class="flex flex-col gap-6 p-7">
                    <div>
                        <Label for="name" :class="labelClass">Product name / crop</Label>
                        <Input
                            id="name"
                            v-model="form.name"
                            type="text"
                            placeholder="Heirloom tomatoes"
                            :class="fieldClass"
                        />
                        <InputError :message="form.errors.name" />
                    </div>

                    <div>
                        <Label for="region" :class="labelClass">Region</Label>
                        <Input
                            id="region"
                            v-model="form.region"
                            type="text"
                            placeholder="Riverside Valley"
                            :class="fieldClass"
                        />
                        <InputError :message="form.errors.region" />
                    </div>

                    <div>
                        <Label for="notes" :class="labelClass"
                            >Notes <span class="text-[#9CA395]">(optional)</span></Label
                        >
                        <textarea
                            id="notes"
                            v-model="form.notes"
                            rows="4"
                            placeholder="Grading, handling, anything merchants should know…"
                            :class="[fieldClass, 'resize-none']"
                        ></textarea>
                        <InputError :message="form.errors.notes" />
                    </div>

                    <div
                        class="flex items-center justify-end gap-3 border-t border-[#E8EAE2] pt-6"
                    >
                        <Link
                            :href="ProductController.index().url"
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
                            Save product
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </GrasslyAppLayout>
</template>

<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import ProductController from '@/actions/App/Http/Controllers/ProductController';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';

const labelClass = 'mb-1.5 block text-[13px] font-bold';
const fieldClass =
    'h-auto w-full rounded-xl border border-[#E8EAE2] bg-white px-4 py-3.5 text-[15px] font-medium text-ink transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] dark:bg-white';

interface ProductForm {
    name: string;
    region: string;
    notes: string | null;
}

const form = useForm<ProductForm>({
    name: '',
    region: '',
    notes: '',
});

function submit() {
    form.post(ProductController.store().url);
}
</script>
