<template>
    <Head title="My products" />

    <GrasslyAppLayout title="My products">
        <template #actions>
            <Link
                :href="createRoute()"
                class="inline-flex items-center gap-2 rounded-xl bg-lime px-[18px] py-[11px] text-sm font-bold text-ink no-underline transition-colors hover:bg-lime-dark"
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
                New product
            </Link>
        </template>

        <!-- EMPTY STATE -->
        <div
            v-if="products.length === 0"
            class="flex min-h-[560px] items-center justify-center p-7"
        >
            <div class="max-w-[420px] text-center">
                <span
                    class="mx-auto mb-7 flex size-[92px] items-center justify-center rounded-[24px] bg-lime-pale"
                >
                    <svg
                        width="42"
                        height="42"
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
                <h2
                    class="mb-2.5 text-[26px] font-extrabold tracking-[-0.02em]"
                >
                    No products yet
                </h2>
                <p
                    class="mx-auto mb-6 max-w-[340px] text-[15px] leading-relaxed text-[#6B7260]"
                >
                    Add the crops you store, then post offers against them so
                    merchants can find and order from you.
                </p>
                <Link
                    :href="createRoute()"
                    class="inline-flex items-center gap-2.5 rounded-xl bg-lime px-[26px] py-3.5 text-[15px] font-bold text-ink no-underline transition-colors hover:bg-lime-dark"
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
                    Add your first product
                </Link>
            </div>
        </div>

        <!-- PRODUCT GRID -->
        <div v-else class="p-7">
            <div class="mb-[18px] text-sm font-bold">
                {{ products.length }} products
            </div>

            <div
                class="grid grid-cols-[repeat(auto-fill,minmax(290px,1fr))] gap-5"
            >
                <article
                    v-for="product in products"
                    :key="product.id"
                    class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
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
                            >Product</span
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

                    <div class="p-[18px]">
                        <div
                            class="mb-2.5 text-lg font-extrabold tracking-[-0.01em]"
                        >
                            {{ product.name }}
                        </div>

                        <div
                            class="mb-3 flex items-center gap-2 text-[13px] text-[#6B7260]"
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
                            {{ product.region }}
                        </div>

                        <div
                            class="mb-3 inline-flex items-center gap-1.5 rounded-full bg-lime-pale px-2.5 py-1 text-xs font-bold text-[#3F5610]"
                        >
                            {{ product.offers_count }}
                            {{
                                product.offers_count === 1 ? 'offer' : 'offers'
                            }}
                        </div>

                        <p
                            class="mb-4 line-clamp-2 min-h-[40px] text-[13px] leading-relaxed text-[#6B7260]"
                        >
                            {{ product.notes ?? 'No notes.' }}
                        </p>

                        <div
                            class="flex items-center gap-2 border-t border-[#E8EAE2] pt-3.5"
                        >
                            <Link
                                :href="ProductController.show(product.id).url"
                                class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-[10px] border border-[#E8EAE2] bg-white py-[9px] text-[13px] font-bold text-ink no-underline transition-colors hover:bg-stone"
                            >
                                View
                            </Link>
                            <Link
                                :href="ProductController.edit(product.id).url"
                                class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-[10px] border border-[#E8EAE2] bg-white py-[9px] text-[13px] font-bold text-ink no-underline transition-colors hover:bg-stone"
                            >
                                Edit
                            </Link>
                            <button
                                type="button"
                                class="flex size-10 flex-none items-center justify-center rounded-[10px] border border-[#E8EAE2] bg-white transition-colors hover:bg-stone"
                                aria-label="Delete product"
                                @click="confirmDelete(product)"
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
            </div>
        </div>

        <!-- DELETE CONFIRMATION — same reusable dialog as the offers pages. -->
        <ConfirmDialog
            :open="deleteTarget !== null"
            title="Delete this product?"
            :description="
                deleteTarget
                    ? `This permanently removes “${deleteTarget.name}”. This can't be undone.`
                    : ''
            "
            confirm-label="Delete product"
            variant="danger"
            @update:open="(value) => !value && cancelDelete()"
            @confirm="performDelete"
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
import { Head, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import ProductController from '@/actions/App/Http/Controllers/ProductController';
import ConfirmDialog from '@/components/grassly/ConfirmDialog.vue';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';
import { create as createRoute } from '@/routes/products/index';

defineProps<{
    products: App.Data.ProductListItemData[];
}>();

const deleteTarget = ref<App.Data.ProductListItemData | null>(null);

function confirmDelete(product: App.Data.ProductListItemData) {
    deleteTarget.value = product;
}

function cancelDelete() {
    deleteTarget.value = null;
}

function performDelete() {
    if (!deleteTarget.value) {
        return;
    }

    router.delete(ProductController.destroy(deleteTarget.value.id).url, {
        onSuccess: () => cancelDelete(),
    });
}
</script>
