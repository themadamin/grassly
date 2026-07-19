<template>
    <Head title="Edit product" />

    <GrasslyAppLayout title="Edit product">
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
                        <div class="text-[19px] font-extrabold text-ink">Edit product</div>
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
                            :class="[fieldClass, 'resize-none']"
                        ></textarea>
                        <InputError :message="form.errors.notes" />
                    </div>

                    <div
                        class="flex items-center justify-between gap-3 border-t border-[#E8EAE2] pt-6"
                    >
                        <button
                            type="button"
                            class="inline-flex items-center gap-2 rounded-xl border border-[#F3C9C8] bg-white px-5 py-3 text-sm font-bold text-alert transition-colors hover:bg-[#FBE4E3]"
                            @click="showDeleteDialog = true"
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
                            Delete
                        </button>
                        <div class="flex items-center gap-3">
                            <Link
                                :href="ProductController.show(product.id).url"
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
                </div>
            </form>
        </div>

        <!-- Delete confirmation. Portaled out of the form, so it's safe here. -->
        <ConfirmDialog
            v-model:open="showDeleteDialog"
            title="Delete this product?"
            :description="`This permanently removes “${product.name}”. This can't be undone.`"
            confirm-label="Delete product"
            variant="danger"
            @confirm="destroy"
        >
            <template #icon>
                <svg
                    width="24"
                    height="24"
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
                    <path d="M10 11 V16" />
                    <path d="M14 11 V16" />
                </svg>
            </template>
        </ConfirmDialog>
    </GrasslyAppLayout>
</template>

<script setup lang="ts">
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import ProductController from '@/actions/App/Http/Controllers/ProductController';
import ConfirmDialog from '@/components/grassly/ConfirmDialog.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';

const labelClass = 'mb-1.5 block text-[13px] font-bold';
const fieldClass =
    'h-auto w-full rounded-xl border border-[#E8EAE2] bg-white px-4 py-3.5 text-[15px] font-medium text-ink transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] dark:bg-white';

const props = defineProps<{
    product: App.Data.ProductData;
}>();

interface ProductForm {
    name: string;
    region: string;
    notes: string | null;
}

const form = useForm<ProductForm>({
    name: props.product.name,
    region: props.product.region,
    notes: props.product.notes,
});

function submit() {
    form.put(ProductController.update(props.product.id).url);
}

const showDeleteDialog = ref(false);

function destroy() {
    router.delete(ProductController.destroy(props.product.id).url);
}
</script>
