<template>
    <Head title="Sign in" />

    <div
        v-if="status"
        class="mb-4 text-center text-sm font-medium text-lime-dark"
    >
        {{ status }}
    </div>

    <Form
        v-bind="store.form()"
        :reset-on-success="['password']"
        v-slot="{ errors, processing }"
        class="rounded-[20px] border border-[#E8EAE2] bg-white p-8"
    >
        <div class="flex flex-col gap-4">
            <div>
                <Label for="email" class="mb-1.5 text-[13px] font-bold"
                    >Email</Label
                >
                <Input
                    id="email"
                    type="email"
                    name="email"
                    required
                    autofocus
                    :tabindex="1"
                    autocomplete="email"
                    placeholder="you@farm.co"
                    class="h-auto rounded-xl border-[#E8EAE2] bg-white px-4 py-3.5 text-[15px] font-medium text-ink dark:bg-white"
                />
                <InputError :message="errors.email" />
            </div>

            <div>
                <div class="mb-1.5 flex items-center justify-between">
                    <Label for="password" class="text-[13px] font-bold"
                        >Password</Label
                    >
                    <TextLink
                        v-if="canResetPassword"
                        :href="request()"
                        class="text-[13px] font-bold text-lime-dark no-underline"
                        :tabindex="5"
                    >
                        Forgot password?
                    </TextLink>
                </div>
                <PasswordInput
                    id="password"
                    name="password"
                    required
                    :tabindex="2"
                    autocomplete="current-password"
                    placeholder="••••••••••"
                    class="h-auto rounded-xl border-[#E8EAE2] bg-white px-4 py-3.5 text-[15px] font-medium text-ink dark:bg-white"
                />
                <InputError :message="errors.password" />
            </div>
        </div>

        <Label
            for="remember"
            class="mt-4 flex cursor-pointer items-center gap-3"
        >
            <Checkbox
                id="remember"
                name="remember"
                :tabindex="3"
                class="size-[22px] rounded-[7px] border-[#C8CCBE] data-[state=checked]:border-lime data-[state=checked]:bg-lime data-[state=checked]:text-ink"
            />
            <span class="text-sm font-semibold text-ink"
                >Remember me on this device</span
            >
        </Label>

        <Button
            type="submit"
            class="mt-6 h-auto w-full rounded-xl bg-lime py-3.5 text-base font-bold text-ink hover:bg-lime-dark"
            :tabindex="4"
            :disabled="processing"
            data-test="login-button"
        >
            <Spinner v-if="processing" />
            Sign in
        </Button>

        <div class="mt-5 text-center text-sm text-[#6B7260]">
            New to Grassly?
            <TextLink
                :href="register()"
                class="font-bold text-ink no-underline"
                :tabindex="5"
                >Create an account</TextLink
            >
        </div>
    </Form>
</template>

<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { register } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';

defineOptions({
    layout: {
        title: 'Welcome back',
        description: 'Sign in to your marketplace account.',
    },
});

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>
