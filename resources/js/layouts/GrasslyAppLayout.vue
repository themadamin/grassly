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
        class="flex h-screen overflow-hidden bg-stone text-ink antialiased"
        style="font-family: 'Plus Jakarta Sans', system-ui, sans-serif"
    >
        <!-- SIDEBAR -->
        <aside
            class="flex w-64 flex-none flex-col border-r border-[#E8EAE2] bg-stone px-4 py-[22px]"
        >
            <!-- Logo -->
            <Link
                :href="home()"
                class="flex items-center gap-2.5 px-2.5 pt-1.5 pb-6"
                aria-label="Grassly home"
            >
                <span class="size-3 rounded-full bg-lime"></span>
                <span class="text-xl font-extrabold tracking-[-0.02em]"
                    >Grassly</span
                >
            </Link>

            <!-- Nav -->
            <nav class="flex flex-col gap-1">
                <SidebarNavLink
                    v-for="item in navItems"
                    :key="item.label"
                    :href="item.href"
                    :label="item.label"
                    :icon="item.icon"
                />
            </nav>

            <!-- User card -->
            <div
                class="mt-auto flex items-center gap-2.5 rounded-[14px] border border-[#E8EAE2] bg-white p-3"
            >
                <span
                    class="flex size-[38px] flex-none items-center justify-center rounded-[11px] bg-ink text-[15px] font-extrabold text-lime"
                    >{{ initials }}</span
                >
                <div class="min-w-0">
                    <div class="truncate text-sm font-bold">{{ userName }}</div>
                    <span
                        class="mt-0.5 inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-[11px] font-bold capitalize"
                        :class="rolePill.wrap"
                    >
                        <span
                            class="size-[5px] rounded-full"
                            :class="rolePill.dot"
                        ></span>
                        {{ role }}
                    </span>
                </div>
            </div>
        </aside>

        <!-- MAIN COLUMN -->
        <div class="flex min-w-0 flex-1 flex-col">
            <!-- TOP BAR -->
            <header
                class="flex h-[74px] flex-none items-center justify-between border-b border-[#E8EAE2] bg-white px-7"
            >
                <h1 class="text-xl font-extrabold tracking-[-0.02em]">
                    {{ title }}
                </h1>

                <div class="flex items-center gap-3">
                    <!-- Notifications -->
                    <button
                        type="button"
                        class="relative flex size-11 flex-none items-center justify-center rounded-xl border border-[#E8EAE2] bg-white"
                        aria-label="Notifications"
                    >
                        <svg
                            width="19"
                            height="19"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#0F1510"
                            stroke-width="2.2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path
                                d="M6 9 a6 6 0 0 1 12 0 c0 5 2 6 2 6 H4 s2 -1 2 -6"
                            />
                            <path d="M10 20 a2 2 0 0 0 4 0" />
                        </svg>
                        <span
                            class="absolute top-2.5 right-2.5 size-2 rounded-full border-2 border-white bg-alert"
                        ></span>
                    </button>

                    <!-- Page-specific action (e.g. New listing / Browse market) -->
                    <slot name="actions" />
                </div>
            </header>

            <!-- PAGE CONTENT -->
            <main class="flex-1 overflow-y-auto bg-stone">
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import type { InertiaLinkProps } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { SidebarIconName } from '@/components/nav/SidebarNavIcon.vue';
import SidebarNavLink from '@/components/nav/SidebarNavLink.vue';
import { useInitials } from '@/composables/useInitials';
import { home, market } from '@/routes';
import { index as demandIndex } from '@/routes/demands/index';
import { dashboard as farmerDashboard } from '@/routes/farmer/index';
import { dashboard as merchantDashboard } from '@/routes/merchant/index';
import { index as offerIndex } from '@/routes/offers/index';
import { index as orderIndex } from '@/routes/orders/index';
import { index as productIndex } from '@/routes/products/index';
import type { UserRole } from '@/types/auth';

defineProps<{
    title: string;
}>();

const page = usePage();
const { getInitials } = useInitials();
const userName = computed<string>(() => page.props.auth.user.name ?? 'No name');
const role = computed<UserRole>(() => page.props.auth.role ?? 'farmer');
const initials = computed(() => getInitials(userName.value));
const rolePill = computed(() =>
    role.value === 'farmer'
        ? { wrap: 'bg-lime-pale text-[#3F5610]', dot: 'bg-[#7AB82A]' }
        : { wrap: 'bg-ink text-white', dot: 'bg-lime' },
);

const dashboardHref = computed(() => {
    const byRole = {
        farmer: farmerDashboard,
        merchant: merchantDashboard,
        admin: merchantDashboard, // TODO: real admin dashboard route when it exists
    } satisfies Record<UserRole, typeof farmerDashboard>;

    return byRole[role.value]().url;
});

type NavItem = {
    label: string;
    href: NonNullable<InertiaLinkProps['href']>;
    icon: SidebarIconName;
};

// The sell/buy slot is role-aware: farmers manage Offers, merchants manage
// Demands (the Offer mirror). Same nav position, different label + destination.
const isMerchant = role.value === 'merchant';
const offersLabel = isMerchant ? 'Demands' : 'Offers';
const offersHref = isMerchant ? demandIndex().url : offerIndex().url;

const navItems: NavItem[] = [
    {
        label: 'Dashboard',
        href: dashboardHref.value,
        icon: 'dashboard',
    },
    { label: 'Market', href: market().url, icon: 'market' },
    { label: 'Products', href: productIndex().url, icon: 'products' },
    { label: offersLabel, href: offersHref, icon: 'offers' },
    { label: 'Orders', href: orderIndex().url, icon: 'orders' },
    { label: 'Harvest', href: '#harvest', icon: 'harvest' },
    { label: 'Chat', href: '#chat', icon: 'chat' },
    { label: 'Feed', href: '#feed', icon: 'feed' },
];
</script>
