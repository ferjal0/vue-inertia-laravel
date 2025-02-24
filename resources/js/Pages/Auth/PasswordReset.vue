<script setup lang="ts">
import ErrorFeedback from '@/components/custom/ErrorFeedback.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthenticationLayout from '@/layouts/AuthenticationLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

interface Props {
    token: string;
}

const props = defineProps<Props>();

const form = useForm({
    _method: 'POST',
    token: props.token,
    email: new URLSearchParams(window.location.search).get('email') || '',
    password: '',
    password_confirmation: '',
});

function submit(e: Event) {
    e.preventDefault();
    form.post(route('password.update'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>

<template>
    <Head>
        <title>Reset Password</title>
    </Head>

    <AuthenticationLayout>
        <form class="flex flex-col gap-6" @submit="submit">
            <div class="flex flex-col items-center gap-4 text-center">
                <h1 class="text-2xl font-bold">Reset your password</h1>
                <p class="text-balance text-sm text-muted-foreground">
                    Please enter your new password below to reset your account
                    password.
                </p>
            </div>

            <ErrorFeedback :message="form.errors.token" />

            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">Email</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        v-model="form.email"
                        class="block w-full"
                        autocomplete="username"
                        required
                        disabled
                    />
                    <ErrorFeedback :message="form.errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="password">New Password</Label>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        v-model="form.password"
                        class="block w-full"
                        autocomplete="new-password"
                        required
                    />
                    <ErrorFeedback :message="form.errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="password_confirmation"
                        >Confirm New Password</Label
                    >
                    <Input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        v-model="form.password_confirmation"
                        class="block w-full"
                        autocomplete="new-password"
                        required
                    />
                    <ErrorFeedback
                        :message="form.errors.password_confirmation"
                    />
                </div>

                <Button
                    type="submit"
                    class="w-full"
                    :disabled="form.processing"
                >
                    Reset Password
                </Button>

                <div class="text-center text-sm">
                    Remember your password?
                    <a
                        :href="route('login')"
                        class="underline underline-offset-4"
                    >
                        Log in
                    </a>
                </div>
            </div>
        </form>
    </AuthenticationLayout>
</template>
