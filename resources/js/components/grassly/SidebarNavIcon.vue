<template>
    <!-- stroke="currentColor" → the icon inherits the link's text colour, so the
         active/inactive state needs no separate colour logic. -->
    <svg
        width="19"
        height="19"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
        stroke-width="2.1"
        stroke-linecap="round"
        stroke-linejoin="round"
    >
        <template v-if="name === 'dashboard'">
            <rect x="4" y="4" width="7" height="7" rx="1.5" />
            <rect x="13" y="4" width="7" height="7" rx="1.5" />
            <rect x="4" y="13" width="7" height="7" rx="1.5" />
            <rect x="13" y="13" width="7" height="7" rx="1.5" />
        </template>
        <template v-else-if="name === 'market'">
            <path d="M4 8 H20" />
            <path d="M5 8 L6 19 H18 L19 8" />
            <path d="M9 8 V6 a3 3 0 0 1 6 0 v2" />
        </template>
        <template v-else-if="name === 'products'">
            <path d="M3 9 L12 4 L21 9 V20 H3 Z" />
            <path d="M9 20 V13 H15 V20" />
        </template>
        <template v-else-if="name === 'offers'">
            <path d="M9 4 H15 L20 9 V20 H4 V9 Z" />
            <path d="M9 4 V9 H4" />
            <path d="M9 13 H15" />
            <path d="M9 16.5 H13" />
        </template>
        <template v-else-if="name === 'orders'">
            <rect x="4" y="4" width="16" height="16" rx="2.5" />
            <path d="M8 9 H16" />
            <path d="M8 13 H16" />
            <path d="M8 17 H12" />
        </template>
        <template v-else-if="name === 'harvest'">
            <path d="M4 18 L9 12 L13 15 L20 6" />
            <path d="M15 6 H20 V11" />
        </template>
        <template v-else-if="name === 'chat'">
            <path d="M4 5 H20 V16 H12 L8 20 V16 H4 Z" />
        </template>
        <template v-else-if="name === 'feed'">
            <circle cx="12" cy="12" r="8" />
            <path d="M4 12 H20" />
            <path d="M12 4 C14.5 7 14.5 17 12 20 C9.5 17 9.5 7 12 4 Z" />
        </template>
    </svg>
</template>

<script lang="ts">
// Exported so the nav array (and SidebarNavLink) can be type-checked against the
// exact set of icons this component knows how to draw. A plain <script> block
// (not <script setup>) is how you export a type/value from an SFC.
export type SidebarIconName =
    | 'dashboard'
    | 'market'
    | 'products'
    | 'offers'
    | 'orders'
    | 'harvest'
    | 'chat'
    | 'feed';
</script>

<script setup lang="ts">
defineProps<{
    name: SidebarIconName;
}>();
</script>
