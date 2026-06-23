<template>
    <Head>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link
            rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin="anonymous"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,500;1,700&display=swap"
            rel="stylesheet"
        />
    </Head>

    <div
        class="flex min-h-svh flex-col items-center justify-start bg-stone px-4 py-14 text-ink antialiased sm:px-10"
        style="font-family: 'Plus Jakarta Sans', system-ui, sans-serif"
    >
        <div class="w-full max-w-[480px]">
            <div class="mb-7 text-center">
                <Link
                    :href="home()"
                    class="mb-5 inline-flex items-center gap-2.5"
                    aria-label="Grassly home"
                >
                    <span class="size-3 rounded-full bg-lime"></span>
                    <span class="text-[22px] font-extrabold tracking-[-0.02em]"
                        >Grassly</span
                    >
                </Link>
                <h1
                    v-if="title"
                    class="text-[34px] font-extrabold tracking-[-0.025em]"
                >
                    {{ title }}
                </h1>
                <p v-if="description" class="mt-3 text-[15px] text-[#6B7260]">
                    {{ description }}
                </p>
            </div>

            <slot />
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { home } from '@/routes';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>
