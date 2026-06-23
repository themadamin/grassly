<template>
    <Head title="Create account" />

    <Form
        v-bind="store.form()"
        :reset-on-success="['password', 'password_confirmation']"
        v-slot="{ errors, processing }"
        class="rounded-[20px] border border-[#E8EAE2] bg-white p-8"
    >
        <!-- Submitted alongside name/email/password by the Inertia <Form> -->
        <input type="hidden" name="role" :value="role" />

        <!-- ROLE SELECT -->
        <div class="mb-2.5 text-[13px] font-bold">I'm joining as</div>
        <div class="mb-6 grid grid-cols-2 gap-3">
            <button
                type="button"
                :tabindex="1"
                class="rounded-[14px] border-[1.5px] p-4 text-left transition-all"
                :class="
                    isFarmer
                        ? 'border-lime bg-lime-pale'
                        : 'border-[#E8EAE2] bg-white'
                "
                @click="selectRole('farmer')"
            >
                <div class="mb-3 flex items-center justify-between">
                    <span
                        class="flex size-10 items-center justify-center rounded-[11px]"
                        :class="isFarmer ? 'bg-lime' : 'bg-stone'"
                    >
                        <svg
                            width="21"
                            height="21"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#0F1510"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M7 20 C7 14 9 11 14 10" />
                            <path
                                d="M14 10 C19 9 21 5 21 5 C21 5 16 4 13 6 C10.5 7.7 10 10 14 10 Z"
                            />
                            <path d="M7 20 C7 17 5 14 3 13 C3 13 4 17 7 20 Z" />
                        </svg>
                    </span>
                    <span
                        v-show="isFarmer"
                        class="flex size-[22px] items-center justify-center rounded-full bg-lime"
                    >
                        <svg
                            width="13"
                            height="13"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#0F1510"
                            stroke-width="3.4"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M5 12 L10 17 L19 7" />
                        </svg>
                    </span>
                </div>
                <div class="text-base font-bold">Farmer</div>
                <div class="mt-0.5 text-[13px] leading-tight text-[#6B7260]">
                    I grow and sell produce
                </div>
            </button>

            <button
                type="button"
                :tabindex="2"
                class="rounded-[14px] border-[1.5px] p-4 text-left transition-all"
                :class="
                    isMerchant
                        ? 'border-lime bg-lime-pale'
                        : 'border-[#E8EAE2] bg-white'
                "
                @click="selectRole('merchant')"
            >
                <div class="mb-3 flex items-center justify-between">
                    <span
                        class="flex size-10 items-center justify-center rounded-[11px]"
                        :class="isMerchant ? 'bg-lime' : 'bg-stone'"
                    >
                        <svg
                            width="21"
                            height="21"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#0F1510"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M5 7 H19 L18 18 H6 Z" />
                            <path d="M9 7 V5 a3 3 0 0 1 6 0 v2" />
                        </svg>
                    </span>
                    <span
                        v-show="isMerchant"
                        class="flex size-[22px] items-center justify-center rounded-full bg-lime"
                    >
                        <svg
                            width="13"
                            height="13"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="#0F1510"
                            stroke-width="3.4"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M5 12 L10 17 L19 7" />
                        </svg>
                    </span>
                </div>
                <div class="text-base font-bold">Merchant</div>
                <div class="mt-0.5 text-[13px] leading-tight text-[#6B7260]">
                    I buy and source produce
                </div>
            </button>
        </div>
        <InputError :message="errors.role" class="-mt-4 mb-4" />

        <!-- FIELDS -->
        <div class="flex flex-col gap-4">
            <div>
                <Label for="name" class="mb-1.5 text-[13px] font-bold"
                    >Full name</Label
                >
                <Input
                    id="name"
                    type="text"
                    name="name"
                    required
                    autofocus
                    :tabindex="3"
                    autocomplete="name"
                    placeholder="Maria Okonkwo"
                    class="h-auto rounded-xl border-[#E8EAE2] bg-white px-4 py-3.5 text-[15px] font-medium text-ink dark:bg-white"
                />
                <InputError :message="errors.name" />
            </div>

            <div>
                <Label for="email" class="mb-1.5 text-[13px] font-bold"
                    >Email</Label
                >
                <Input
                    id="email"
                    type="email"
                    name="email"
                    required
                    :tabindex="4"
                    autocomplete="email"
                    placeholder="you@farm.co"
                    class="h-auto rounded-xl border-[#E8EAE2] bg-white px-4 py-3.5 text-[15px] font-medium text-ink dark:bg-white"
                />
                <InputError :message="errors.email" />
            </div>

            <div>
                <Label for="password" class="mb-1.5 text-[13px] font-bold"
                    >Password</Label
                >
                <PasswordInput
                    id="password"
                    name="password"
                    required
                    :tabindex="5"
                    autocomplete="new-password"
                    placeholder="••••••••••"
                    :passwordrules="passwordRules"
                    class="h-auto rounded-xl border-[#E8EAE2] bg-white px-4 py-3.5 text-[15px] font-medium text-ink dark:bg-white"
                />
                <p class="mt-1.5 text-xs text-[#6B7260]">
                    At least 8 characters.
                </p>
                <InputError :message="errors.password" />
            </div>

            <div>
                <Label
                    for="password_confirmation"
                    class="mb-1.5 text-[13px] font-bold"
                    >Confirm password</Label
                >
                <PasswordInput
                    id="password_confirmation"
                    name="password_confirmation"
                    required
                    :tabindex="6"
                    autocomplete="new-password"
                    placeholder="••••••••••"
                    :passwordrules="passwordRules"
                    class="h-auto rounded-xl border-[#E8EAE2] bg-white px-4 py-3.5 text-[15px] font-medium text-ink dark:bg-white"
                />
                <InputError :message="errors.password_confirmation" />
            </div>
        </div>

        <Button
            type="submit"
            class="mt-6 h-auto w-full rounded-xl bg-lime py-4 text-base font-bold text-ink hover:bg-lime-dark"
            :tabindex="7"
            :disabled="processing"
            data-test="register-user-button"
        >
            <Spinner v-if="processing" />
            Create account
        </Button>

        <div class="mt-5 text-center text-sm text-[#6B7260]">
            Already have an account?
            <TextLink
                :href="login()"
                class="font-bold text-ink no-underline"
                :tabindex="8"
                >Sign in</TextLink
            >
        </div>
    </Form>

    <p
        class="mx-auto mt-4.5 max-w-[380px] text-center text-xs leading-normal text-[#8A9180]"
    >
        Admin accounts are assigned manually and aren't available here.
    </p>
</template>

<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import InputError from '@/components/InputError.vue';
import PasswordInput from '@/components/PasswordInput.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { login } from '@/routes';
import { store } from '@/routes/register';

defineProps<{
    passwordRules: string;
}>();

defineOptions({
    layout: {
        title: 'Create your account',
        description: 'Join the marketplace as a farmer or a merchant.',
    },
});

type UserRole = 'farmer' | 'merchant';

const role = ref<UserRole>('farmer');

function selectRole(next: UserRole) {
    role.value = next;
}

const isFarmer = computed(() => role.value === 'farmer');
const isMerchant = computed(() => role.value === 'merchant');

// The hidden <input name="role"> below submits role.value with the Inertia
// <Form>. The backend is wired: CreateNewUser validates it against
// UserRole::selfAssignable() and calls $user->assignRole() via
// spatie/laravel-permission. (Roles are seeded by RoleSeeder.)
</script>
