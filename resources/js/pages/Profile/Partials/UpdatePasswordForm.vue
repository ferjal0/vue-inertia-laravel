<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { cn } from '@/lib/utils';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { toast } from 'vue-sonner';

interface Props {
    className?: string;
}

defineProps<Props>();

const passwordInput = ref<HTMLInputElement>();
const currentPasswordInput = ref<HTMLInputElement>();

const form = useForm({
    _method: 'PUT',
    current_password: '',
    password: '',
    password_confirmation: '',
});

function updatePassword(e: Event) {
    e.preventDefault();

    form.post(route('user-password.update'), {
        errorBag: 'updatePassword',
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            toast.success('Password updated successfully');
        },
        onError: (errors) => {
            if (errors.password) {
                form.reset('password', 'password_confirmation');
            }

            if (errors.current_password) {
                form.reset('current_password');
            }
        },
    });
}
</script>

<template>
    <section :class="cn('flex flex-col gap-6', className)">
        <header class="flex flex-col gap-2">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Update Password
            </h2>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Ensure your account is using a long, random password to stay
                secure.
            </p>
        </header>

        <form @submit="updatePassword" class="flex flex-col gap-4">
            <div class="flex flex-col gap-2">
                <Label for="current_password">Current Password</Label>

                <Input
                    id="current_password"
                    v-model="form.current_password"
                    type="password"
                    class="max-w-lg"
                    autocomplete="current-password"
                    ref="currentPasswordInput"
                />

                <p
                    v-if="form.errors.current_password"
                    class="mt-2 text-sm text-red-600 dark:text-red-400"
                >
                    {{ form.errors.current_password }}
                </p>
            </div>

            <div class="flex flex-col gap-2">
                <Label for="password">New Password</Label>

                <Input
                    id="password"
                    v-model="form.password"
                    type="password"
                    class="max-w-lg"
                    autocomplete="new-password"
                    ref="passwordInput"
                />

                <p
                    v-if="form.errors.password"
                    class="mt-2 text-sm text-red-600 dark:text-red-400"
                >
                    {{ form.errors.password }}
                </p>
            </div>

            <div class="flex flex-col gap-2">
                <Label for="password_confirmation">Confirm Password</Label>

                <Input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="max-w-lg"
                    autocomplete="new-password"
                />

                <p
                    v-if="form.errors.password_confirmation"
                    class="mt-2 text-sm text-red-600 dark:text-red-400"
                >
                    {{ form.errors.password_confirmation }}
                </p>
            </div>

            <div class="flex items-center gap-4">
                <Button type="submit" :disabled="form.processing">Save</Button>
            </div>
        </form>
    </section>
</template>
