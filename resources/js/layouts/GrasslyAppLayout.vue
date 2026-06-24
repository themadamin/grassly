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
                <Link
                    :href="'#dashboard'"
                    :class="[
                        navBase,
                        isActive('#dashboard') ? activeNav : inactiveNav,
                    ]"
                >
                    <svg
                        width="19"
                        height="19"
                        viewBox="0 0 24 24"
                        fill="none"
                        :stroke="navStroke('#dashboard')"
                        stroke-width="2.1"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect x="4" y="4" width="7" height="7" rx="1.5" />
                        <rect x="13" y="4" width="7" height="7" rx="1.5" />
                        <rect x="4" y="13" width="7" height="7" rx="1.5" />
                        <rect x="13" y="13" width="7" height="7" rx="1.5" />
                    </svg>
                    <span>Dashboard</span>
                </Link>

                <Link
                    :href="'#market'"
                    :class="[
                        navBase,
                        isActive('#market') ? activeNav : inactiveNav,
                    ]"
                >
                    <svg
                        width="19"
                        height="19"
                        viewBox="0 0 24 24"
                        fill="none"
                        :stroke="navStroke('#market')"
                        stroke-width="2.1"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M4 8 H20" />
                        <path d="M5 8 L6 19 H18 L19 8" />
                        <path d="M9 8 V6 a3 3 0 0 1 6 0 v2" />
                    </svg>
                    <span>Market</span>
                </Link>

                <Link
                    :href="'#storage'"
                    :class="[
                        navBase,
                        isActive('#storage') ? activeNav : inactiveNav,
                    ]"
                >
                    <svg
                        width="19"
                        height="19"
                        viewBox="0 0 24 24"
                        fill="none"
                        :stroke="navStroke('#storage')"
                        stroke-width="2.1"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M3 9 L12 4 L21 9 V20 H3 Z" />
                        <path d="M9 20 V13 H15 V20" />
                    </svg>
                    <span>Storage</span>
                </Link>

                <Link
                    :href="'#orders'"
                    :class="[
                        navBase,
                        isActive('#orders') ? activeNav : inactiveNav,
                    ]"
                >
                    <svg
                        width="19"
                        height="19"
                        viewBox="0 0 24 24"
                        fill="none"
                        :stroke="navStroke('#orders')"
                        stroke-width="2.1"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <rect x="4" y="4" width="16" height="16" rx="2.5" />
                        <path d="M8 9 H16" />
                        <path d="M8 13 H16" />
                        <path d="M8 17 H12" />
                    </svg>
                    <span>Orders</span>
                </Link>

                <Link
                    :href="'#harvest'"
                    :class="[
                        navBase,
                        isActive('#harvest') ? activeNav : inactiveNav,
                    ]"
                >
                    <svg
                        width="19"
                        height="19"
                        viewBox="0 0 24 24"
                        fill="none"
                        :stroke="navStroke('#harvest')"
                        stroke-width="2.1"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M4 18 L9 12 L13 15 L20 6" />
                        <path d="M15 6 H20 V11" />
                    </svg>
                    <span>Harvest</span>
                </Link>

                <Link
                    :href="'#chat'"
                    :class="[
                        navBase,
                        isActive('#chat') ? activeNav : inactiveNav,
                    ]"
                >
                    <svg
                        width="19"
                        height="19"
                        viewBox="0 0 24 24"
                        fill="none"
                        :stroke="navStroke('#chat')"
                        stroke-width="2.1"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M4 5 H20 V16 H12 L8 20 V16 H4 Z" />
                    </svg>
                    <span>Chat</span>
                </Link>

                <Link
                    :href="'#feed'"
                    :class="[
                        navBase,
                        isActive('#feed') ? activeNav : inactiveNav,
                    ]"
                >
                    <svg
                        width="19"
                        height="19"
                        viewBox="0 0 24 24"
                        fill="none"
                        :stroke="navStroke('#feed')"
                        stroke-width="2.1"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <circle cx="12" cy="12" r="8" />
                        <path d="M4 12 H20" />
                        <path
                            d="M12 4 C14.5 7 14.5 17 12 20 C9.5 17 9.5 7 12 4 Z"
                        />
                    </svg>
                    <span>Feed</span>
                </Link>
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
                    <!-- Search -->
                    <div class="relative w-60">
                        <svg
                            class="absolute top-1/2 left-3.5 -translate-y-1/2"
                            width="17"
                            height="17"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#6B7260"
                            stroke-width="2.2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <circle cx="11" cy="11" r="7" />
                            <path d="M21 21 L16.5 16.5" />
                        </svg>
                        <!-- TODO(you): wire search. For now it's a styled, inert input.
                             Hint: v-model a ref, then debounce an Inertia router.get()
                             to a search route once one exists. -->
                        <input
                            type="search"
                            placeholder="Search…"
                            class="w-full rounded-xl border border-[#E8EAE2] bg-stone py-[11px] pr-3.5 pl-10 text-sm font-medium text-ink outline-none placeholder:text-[#6B7260]"
                        />
                    </div>

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
import { computed } from 'vue';
import { useInitials } from '@/composables/useInitials';
import { home } from '@/routes';
import type { UserRole } from '@/types/auth';

defineProps<{
    title: string;
}>();

const page = usePage();
const { getInitials } = useInitials();

// Shared base classes for nav links; active/inactive variants layered on top.
const navBase =
    'flex items-center gap-3 rounded-xl px-3.5 py-[11px] text-[15px] transition-colors';
const activeNav = 'bg-lime font-bold text-ink';
const inactiveNav = 'font-semibold text-[#6B7260] hover:bg-lime-pale/60';

// TODO(you): the bottom user card should show the signed-in user. Replace these
// placeholders by reading the shared auth prop.
// Hint: import { usePage } from '@inertiajs/vue3'; const page = usePage();
//   page.props.auth.user (its .name) and page.props.auth.role are typed as
//   `Auth` via resources/js/types/global.d.ts. Wrap each read in computed() so
//   the card stays reactive if the user changes.
const userName = computed<string>(() => page.props.auth.user.name ?? 'No name');
const role = computed<UserRole>(() => page.props.auth.role ?? 'farmer');

// Avatar initials, derived from the name. (useInitials is the project helper.)
const initials = computed(() => getInitials(userName.value));

// Role-driven pill colours: farmer = lime-pale chip, otherwise ink. Styling
// only — it keys off `role` above.
const rolePill = computed(() =>
    role.value === 'farmer'
        ? { wrap: 'bg-lime-pale text-[#3F5610]', dot: 'bg-[#7AB82A]' }
        : { wrap: 'bg-ink text-white', dot: 'bg-lime' },
);

// TODO(you): highlight the nav item matching the current page. Each <Link>
// passes its href to isActive() for the :class binding above.
// Hint: useCurrentUrl().isCurrentUrl(href) (from '@/composables/useCurrentUrl')
// compares a href against the current Inertia URL — import it and
// `return isCurrentUrl(href)`. Point the '#...' hrefs at real routes as each
// section gets built.
function isActive(href: string): boolean {
    return href === '__active__'; // TODO(you): return isCurrentUrl(href)
}

// Nav icon stroke colour follows the active state.
function navStroke(href: string): string {
    return isActive(href) ? '#0F1510' : '#6B7260';
}
</script>
