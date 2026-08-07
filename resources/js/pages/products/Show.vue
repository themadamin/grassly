<template>
    <Head :title="product.name" />

    <GrasslyAppLayout title="Product detail">
        <template #actions>
            <Link
                :href="ProductController.index().url"
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
                Back to products
            </Link>
        </template>

        <div class="p-7">
            <div
                class="grid grid-cols-[1fr_340px] items-start gap-6 max-lg:grid-cols-1"
            >
                <!-- LEFT: detail -->
                <div class="flex flex-col gap-6">
                    <div
                        class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                    >
                        <div
                            class="relative flex items-start justify-between p-6"
                            style="
                                min-height: 130px;
                                background-color: #a8e63d;
                                background-image: repeating-radial-gradient(
                                    circle at 82% 24%,
                                    transparent 0 16px,
                                    rgba(15, 21, 16, 0.07) 16px 17.5px
                                );
                            "
                        >
                            <div>
                                <div
                                    class="mb-2 text-xs font-extrabold tracking-[0.13em] text-[#3F5610] uppercase"
                                >
                                    Product
                                </div>
                                <h1
                                    class="text-[34px] font-extrabold tracking-[-0.025em] text-ink"
                                >
                                    {{ product.name }}
                                </h1>
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
                        <div class="grid grid-cols-2 gap-5 p-6">
                            <div>
                                <div
                                    class="mb-1.5 text-xs font-bold tracking-[0.04em] text-[#6B7260] uppercase"
                                >
                                    Region
                                </div>
                                <div class="text-lg font-bold">
                                    {{ product.region }}
                                </div>
                            </div>
                            <div>
                                <div
                                    class="mb-1.5 text-xs font-bold tracking-[0.04em] text-[#6B7260] uppercase"
                                >
                                    Offers
                                </div>
                                <div class="text-lg font-bold">
                                    {{ product.offers_count }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="rounded-[20px] border border-[#E8EAE2] bg-white p-6"
                    >
                        <h3
                            class="mb-3 text-lg font-extrabold tracking-[-0.01em]"
                        >
                            Notes
                        </h3>
                        <p class="text-[15px] leading-relaxed text-[#4A5142]">
                            {{ product.notes ?? 'No notes provided.' }}
                        </p>
                    </div>

                    <div
                        class="flex items-center gap-4 rounded-[20px] border border-[#E8EAE2] bg-white p-6"
                    >
                        <span
                            class="flex size-[54px] flex-none items-center justify-center rounded-[14px] bg-ink text-lg font-extrabold text-lime"
                        >
                            {{ getInitials(product.farmer?.name ?? '') }}
                        </span>
                        <div class="min-w-0 flex-1">
                            <div class="text-[17px] font-extrabold">
                                {{ product.farmer?.name ?? 'Unknown farmer' }}
                            </div>
                            <div class="mt-0.5 text-[13px] text-[#6B7260]">
                                {{ product.region }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: owner actions -->
                <div class="flex flex-col gap-[18px]">
                    <div
                        v-if="isOwner"
                        class="overflow-hidden rounded-[20px] border border-[#E8EAE2] bg-white"
                    >
                        <div
                            class="bg-ink px-[18px] py-2.5 text-[11px] font-extrabold tracking-[0.13em] text-lime uppercase"
                        >
                            Manage product
                        </div>
                        <div class="p-[22px]">
                            <!-- Domain: a product page shortcuts into the Offer create
                                 form (pre-filling product_id lands with the reshape). -->
                            <Link
                                :href="
                                    OfferController.create({
                                        query: { product_id: product.id },
                                    }).url
                                "
                                class="mb-2.5 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-lime py-3.5 text-[15px] font-bold text-ink no-underline transition-colors hover:bg-lime-dark"
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
                                New offer for this product
                            </Link>
                            <Link
                                :href="ProductController.edit(product.id).url"
                                class="mb-2.5 inline-flex w-full items-center justify-center gap-2 rounded-xl bg-ink py-3.5 text-[15px] font-bold text-white no-underline transition-colors hover:bg-ink/90"
                            >
                                <svg
                                    width="16"
                                    height="16"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="#A8E63D"
                                    stroke-width="2.2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M4 20 H8 L18 10 L14 6 L4 16 Z" />
                                    <path d="M13 7 L17 11" />
                                </svg>
                                Edit product
                            </Link>
                            <button
                                type="button"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-xl border border-[#F3C9C8] bg-white py-3.5 text-[15px] font-bold text-alert transition-colors hover:bg-[#FBE4E3]"
                                @click="showDeleteDialog = true"
                            >
                                <svg
                                    width="16"
                                    height="16"
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
                                Delete product
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete confirmation. Boolean v-model:open; @confirm runs destroy. -->
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
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import OfferController from '@/actions/App/Http/Controllers/OfferController';
import ProductController from '@/actions/App/Http/Controllers/ProductController';
import ConfirmDialog from '@/components/grassly/ConfirmDialog.vue';
import { useInitials } from '@/composables/useInitials';
import GrasslyAppLayout from '@/layouts/GrasslyAppLayout.vue';
import type { Product } from '@/types/product';

const props = defineProps<{
    product: Product;
}>();

const page = usePage();
const { getInitials } = useInitials();

const isOwner = computed(
    () => page.props.auth.user?.id === props.product.user_id,
);

const showDeleteDialog = ref(false);

function destroy() {
    router.delete(ProductController.destroy(props.product.id).url);
}
</script>
