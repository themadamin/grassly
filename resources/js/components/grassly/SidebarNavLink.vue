<template>
    <Link
        :href="href"
        :class="[
            'flex items-center gap-3 rounded-xl px-3.5 py-[11px] text-[15px] transition-colors',
            isActive
                ? 'bg-lime font-bold text-ink'
                : 'font-semibold text-[#6B7260] hover:bg-lime-pale/60',
        ]"
    >
        <SidebarNavIcon :name="icon" />
        <span>{{ label }}</span>
    </Link>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import type { InertiaLinkProps } from '@inertiajs/vue3';
import { computed } from 'vue';
import SidebarNavIcon from './SidebarNavIcon.vue';
import type {SidebarIconName} from './SidebarNavIcon.vue';
import { useCurrentUrl } from '@/composables/useCurrentUrl';

const props = defineProps<{
    // Accepts whatever <Link> accepts — a string OR a Wayfinder RouteDefinition.
    href: NonNullable<InertiaLinkProps['href']>;
    label: string;
    icon: SidebarIconName;
}>();

const { isCurrentOrParentUrl } = useCurrentUrl();

// Section-aware: lights up on the index AND its children (e.g. /offers/5).
const isActive = computed(() => isCurrentOrParentUrl(props.href));
</script>
