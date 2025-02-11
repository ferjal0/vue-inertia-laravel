<script setup lang="ts">
import ErrorFeedback from '@/components/custom/ErrorFeedback.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthenticationLayout from '@/layouts/AuthenticationLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

interface Props {
    isRegisterEnabled: boolean;
}

defineProps<Props>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit(e: Event) {
    e.preventDefault();
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
}
</script>

<template>
    <Head>
        <title>Login</title>
    </Head>

    <AuthenticationLayout>
        <form class="flex flex-col gap-6" @submit="submit">
            <div class="flex flex-col items-center gap-2 text-center">
                <h1 class="text-2xl font-bold">Login to your account</h1>
                <p class="text-balance text-sm text-muted-foreground">
                    Enter your email below to login to your account
                </p>
            </div>
            <ErrorFeedback :message="form.errors.email" class="text-center" />
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="email">Email</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        v-model="form.email"
                        autocomplete="username"
                        placeholder="m@example.com"
                        required
                        autofocus
                    />
                </div>
                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        v-model="form.password"
                        autocomplete="current-password"
                        placeholder="••••••••"
                        required
                    />
                </div>
                <Button
                    type="submit"
                    class="w-full"
                    :disabled="form.processing"
                >
                    Login
                </Button>
                <div class="text-center text-sm">
                    <Link
                        :href="route('auth.forgot-password')"
                        class="underline underline-offset-4"
                    >
                        Forgot your password?
                    </Link>
                </div>
            </div>
            <div
                v-if="isRegisterEnabled"
                class="flex justify-center gap-1 text-sm"
            >
                Don't have an account?
                <Link
                    :href="route('register')"
                    class="underline underline-offset-4"
                >
                    Sign up
                </Link>
            </div>
        </form>
    </AuthenticationLayout>
</template>
