<template>
    <!--
      Controlled dialog: the PARENT owns the open state and passes it in.
      `:open` + `@update:open` is exactly what `v-model:open="..."` expands to,
      so a parent can write `<ConfirmDialog v-model:open="show" />`.
      Dialog/DialogContent come from the shadcn-vue primitive (reka-ui under the
      hood), so focus-trap, Esc-to-close, backdrop and aria wiring are handled.
    -->
    <Dialog :open="open" @update:open="$emit('update:open', $event)">
        <DialogContent
            :show-close-button="false"
            class="w-[440px] gap-0 overflow-hidden rounded-[20px] border-[#E8EAE2] bg-white p-0"
        >
            <div class="px-7 pt-7 pb-6">
                <!-- Icon. Defaults per variant; override with the #icon slot. -->
                <div
                    class="mb-[18px] flex size-[52px] items-center justify-center rounded-[14px]"
                    :class="accent.iconBg"
                >
                    <slot name="icon">
                        <svg
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            :stroke="accent.iconStroke"
                            stroke-width="2.2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M12 3 L22 20 H2 Z" />
                            <path d="M12 10 V14" />
                            <path d="M12 17 h0.01" />
                        </svg>
                    </slot>
                </div>

                <!-- DialogTitle/Description aren't just styling — they set the
                     aria-labelledby / aria-describedby the primitive needs. -->
                <DialogTitle
                    class="mb-2 text-[22px] font-extrabold tracking-[-0.02em] text-ink"
                >
                    {{ title }}
                </DialogTitle>
                <DialogDescription
                    v-if="description"
                    class="text-sm leading-normal text-[#6B7260]"
                >
                    {{ description }}
                </DialogDescription>
            </div>

            <div class="flex gap-3 px-7 pb-7">
                <!-- DialogClose closes the dialog for us (emits update:open=false
                     through the controlled root) — no handler needed. -->
                <DialogClose as-child>
                    <button
                        type="button"
                        class="flex-1 rounded-xl border border-[#E8EAE2] bg-white py-3.5 text-[15px] font-bold text-ink transition-colors hover:bg-stone"
                    >
                        {{ cancelLabel }}
                    </button>
                </DialogClose>

                <!-- Confirm only ANNOUNCES intent via the `confirm` event; the
                     parent decides what actually happens (delete, etc.). -->
                <button
                    type="button"
                    class="flex-1 rounded-xl py-3.5 text-[15px] font-bold transition-colors"
                    :class="accent.confirmBtn"
                    @click="$emit('confirm')"
                >
                    {{ confirmLabel }}
                </button>
            </div>
        </DialogContent>
    </Dialog>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogTitle,
} from '@/components/ui/dialog';

// defineProps<T>() declares this component's inputs at compile time. withDefaults
// supplies fallbacks so callers only pass what they need. `open` + `title` are
// required; the rest are optional.
const props = withDefaults(
    defineProps<{
        open: boolean;
        title: string;
        description?: string;
        confirmLabel?: string;
        cancelLabel?: string;
        variant?: 'danger' | 'default';
    }>(),
    {
        description: undefined,
        confirmLabel: 'Confirm',
        cancelLabel: 'Cancel',
        variant: 'danger',
    },
);

// defineEmits<T>() declares the events sent UP to the parent. The tuple after
// each name is the payload type:
//   'update:open': carries a boolean → this is what powers v-model:open
//   'confirm':     carries nothing   → "the user confirmed"
defineEmits<{
    'update:open': [value: boolean];
    confirm: [];
}>();

// Swap accent colours by variant. `danger` = destructive (delete); `default` =
// a neutral/positive confirm.
const accent = computed(() =>
    props.variant === 'danger'
        ? {
              iconBg: 'bg-[#FBE4E3]',
              iconStroke: '#E24B4A',
              confirmBtn: 'bg-alert text-white hover:brightness-95',
          }
        : {
              iconBg: 'bg-lime-pale',
              iconStroke: '#5C8A1A',
              confirmBtn: 'bg-lime text-ink hover:bg-lime-dark',
          },
);
</script>
