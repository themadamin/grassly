<template>
    <input
        ref="inputEl"
        type="text"
        inputmode="decimal"
        :value="display"
        :placeholder="placeholder"
        @input="onInput"
        @focus="onFocus"
        @blur="onBlur"
    />
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';

// A currency text input that keeps the FORM value a plain decimal number (major
// units, e.g. 1234.5) while showing the user a nicely formatted string.
//
//  - while typing: strips anything that isn't a digit or a single dot (so commas,
//    letters, extra dots and a leading minus can't be entered) and caps decimals.
//  - on blur: pads to `decimals` (12.5 → 12.50), adds thousands grouping
//    (1234.5 → 1,234.50) and clamps to [min, max].
//
// It emits `null` when empty so the backend's `required` rule catches a blank —
// blank is deliberately NOT coerced to 0. Grouping is en-US (comma groups, dot
// decimal), matching App\Enums\Currency::format on the backend.
const props = withDefaults(
    defineProps<{
        modelValue: number | null;
        decimals?: number;
        max?: number;
        min?: number;
        placeholder?: string;
    }>(),
    {
        decimals: 2,
        max: 9999.99,
        min: 0,
        placeholder: '0.00',
    },
);

const emit = defineEmits<{
    'update:modelValue': [value: number | null];
}>();

const inputEl = ref<HTMLInputElement | null>(null);
const display = ref('');
const focused = ref(false);

// Resting (unfocused) look: grouped + padded — 1234.5 → "1,234.50".
function formatGrouped(value: number): string {
    return value.toLocaleString('en-US', {
        minimumFractionDigits: props.decimals,
        maximumFractionDigits: props.decimals,
    });
}

// Editing (focused) look: plain, no grouping/padding — 1234.5 → "1234.5" — so the
// caret never fights inserted commas while typing.
function formatPlain(value: number): string {
    return String(value);
}

// Keep only digits + a single dot, capped to `decimals` places. This is what
// blocks commas/letters/minus/second-dot from ever entering the field.
function sanitize(raw: string): string {
    let s = raw.replace(/[^\d.]/g, '');

    const firstDot = s.indexOf('.');
    if (firstDot !== -1) {
        const intPart = s.slice(0, firstDot);
        const decPart = s
            .slice(firstDot + 1)
            .replace(/\./g, '')
            .slice(0, props.decimals);
        s = `${intPart}.${decPart}`;
    }

    return s;
}

function parse(s: string): number | null {
    if (s === '' || s === '.') {
        return null;
    }
    const n = Number.parseFloat(s);

    return Number.isNaN(n) ? null : n;
}

// Reflect external value changes (initial render, edit prefill, form.reset())
// into the display — but only while not focused, so we never reformat mid-type.
watch(
    () => props.modelValue,
    (value) => {
        if (focused.value) {
            return;
        }
        display.value =
            value === null || value === undefined ? '' : formatGrouped(value);
    },
    { immediate: true },
);

function onInput(event: Event) {
    const el = event.target as HTMLInputElement;
    const clean = sanitize(el.value);

    display.value = clean;
    // If we stripped a character, force the DOM back in sync (caret goes to end,
    // which is fine since the removed char was invalid).
    if (el.value !== clean) {
        el.value = clean;
    }

    emit('update:modelValue', parse(clean));
}

function onFocus() {
    focused.value = true;
    display.value =
        props.modelValue === null || props.modelValue === undefined
            ? ''
            : formatPlain(props.modelValue);
}

function onBlur() {
    focused.value = false;

    const value = props.modelValue;
    if (value === null || value === undefined) {
        display.value = '';

        return;
    }

    // Round to `decimals` and clamp — the same guarantees the server re-checks.
    const factor = 10 ** props.decimals;
    const clamped = Math.min(
        Math.max(Math.round(value * factor) / factor, props.min),
        props.max,
    );

    emit('update:modelValue', clamped);
    display.value = formatGrouped(clamped);
}
</script>
