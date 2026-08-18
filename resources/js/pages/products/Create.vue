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
                <div
                    class="relative flex items-center justify-between bg-lime px-7 py-5"
                >
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
                            <path d="M3 9 L12 4 L21 9 V20 H3 Z" />
                            <path d="M9 20 V13 H15 V20" />
                        </svg>
                    </span>
                </div>

                <div class="flex flex-col gap-6 p-7">
                    <div>
                        <Label for="name" :class="labelClass"
                            >Product name</Label
                        >
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
                        <Label for="category_id" :class="labelClass"
                            >Category
                            <span class="text-[#9CA395]"
                                >(narrows the crop search below)</span
                            ></Label
                        >
                        <select
                            id="category_id"
                            v-model.number="category"
                            :class="fieldClass"
                            @change="onCategoryChange"
                        >
                            <option :value="null">All categories</option>
                            <option
                                v-for="option in categories"
                                :key="option.id"
                                :value="option.id"
                            >
                                {{ option.name }}
                            </option>
                        </select>
                    </div>

                    <div class="relative">
                        <Label for="crop_search" :class="labelClass"
                            >Crop</Label
                        >
                        <input
                            id="crop_search"
                            v-model="cropQuery"
                            type="text"
                            autocomplete="off"
                            placeholder="Search crops…"
                            :class="fieldClass"
                            @input="onCropQueryInput"
                            @focus="onCropFocus"
                            @blur="onCropBlur"
                        />
                        <div
                            v-if="cropOptions.length > 0"
                            class="absolute top-[calc(100%+4px)] right-0 left-0 z-10 max-h-[210px] overflow-y-auto rounded-xl border border-[#E8EAE2] bg-white shadow-[0_10px_24px_rgba(15,21,16,0.12)]"
                        >
                            <div
                                v-for="option in cropOptions"
                                :key="option.id"
                                class="cursor-pointer px-4 py-2.5 text-sm font-semibold text-ink hover:bg-stone"
                                @mousedown.prevent
                                @click="selectCrop(option)"
                            >
                                {{ option.name }}
                            </div>
                        </div>
                        <InputError :message="form.errors.crop_id" />
                    </div>

                    <div>
                        <Label for="notes" :class="labelClass"
                            >Notes
                            <span class="text-[#9CA395]"
                                >(optional)</span
                            ></Label
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
import { ref } from 'vue';
import CropController from '@/actions/App/Http/Controllers/CropController';
import ProductController from '@/actions/App/Http/Controllers/ProductController';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';
import { fetchJson } from '@/lib/utils';
import type { Category } from '@/types/category';
import type { Crop } from '@/types/crop';

defineProps<{
    categories: Category[];
}>();

const labelClass = 'mb-1.5 block text-[13px] font-bold';
const fieldClass =
    'h-auto w-full rounded-xl border border-[#E8EAE2] bg-white px-4 py-3.5 text-[15px] font-medium text-ink transition-[color,box-shadow] outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] dark:bg-white';

interface ProductForm {
    name: string;
    crop_id: number | null;
    notes: string | null;
}

const form = useForm<ProductForm>({
    name: '',
    crop_id: null,
    notes: '',
});

// `category` only narrows the crop search below — it isn't submitted, the
// product only stores crop_id.
const category = ref<number | null>(null);
const cropQuery = ref('');
const cropOptions = ref<Crop[]>([]);
let searchToken = 0;
let debounceTimer: ReturnType<typeof setTimeout> | undefined;

async function searchCrops(
    categoryId: number | null,
    term: string,
): Promise<Crop[]> {
    const url = CropController.index.url({
        query: {
            category_id: categoryId,
            query: term,
        },
    });

    const response = await fetchJson<Crop[] | null>(url);

    if (!response) {
        return [];
    }

    return response;
}

// Shared by every trigger below (typed, focused, category change) so they
// all use one staleness guard: a response only gets applied if no newer
// search has started since, otherwise a slow response to an earlier
// keystroke could overwrite a faster, more recent one.
async function runSearch(term: string = cropQuery.value) {
    const token = ++searchToken;
    const results = await searchCrops(category.value, term);

    if (token === searchToken) {
        cropOptions.value = results;
    }
}

function selectCrop(option: Crop) {
    form.crop_id = option.id;
    cropQuery.value = option.name;
    cropOptions.value = [];
    category.value = option.category.id;
}

function clearCrop() {
    form.crop_id = null;
    cropQuery.value = '';
}

// Tied to the <select>'s own @change, not a generic watch(category, ...) —
// so it can't also fire as a side effect of selectCrop() setting
// category.value above.
async function onCategoryChange() {
    clearCrop();
    await runSearch();
}

function onCropQueryInput() {
    // The text no longer matches the previously picked crop the moment the
    // user types — invalidate it now, don't wait for the debounced search.
    form.crop_id = null;

    if (debounceTimer !== undefined) {
        clearTimeout(debounceTimer);
    }

    debounceTimer = setTimeout(() => {
        debounceTimer = undefined;
        void runSearch();
    }, 300);
}

async function onCropFocus() {
    // Empty term, not the leftover text from an already-selected crop —
    // otherwise re-focusing a filled-in field only shows close matches to
    // the current value instead of the full category list.
    await runSearch('');
}

// mousedown.prevent on each option (template) stops it from blurring the
// input before its click fires, so this can close unconditionally.
function onCropBlur() {
    cropOptions.value = [];
}

function submit() {
    form.post(ProductController.store().url);
}
</script>
