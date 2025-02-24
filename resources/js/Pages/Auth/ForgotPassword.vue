<script setup lang="ts">
import ErrorFeedback from '@/components/custom/ErrorFeedback.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthenticationLayout from '@/layouts/AuthenticationLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';

interface Props {
    status?: string;
}

defineProps<Props>();

const form = useForm({
    email: '',
});

function submit(e: Event) {
    e.preventDefault();
    form.post(route('password.email'), {
        onSuccess: () => router.visit(route('forgot-password.sent')),
    });
}
</script>

<template>
    <Head>
        <title>Forgot Password</title>
    </Head>

    <AuthenticationLayout>
        <form class="flex flex-col gap-6" @submit="submit">
            <div class="flex flex-col items-center gap-4 text-center">
                <h1 class="text-2xl font-bold">Forgot your password?</h1>
                <p class="text-balance text-sm text-muted-foreground">
                    No problem. Let us know your email address and we will email
                    you a password reset link.
                </p>
            </div>

            <div
                v-if="status"
                class="text-center text-sm font-medium text-green-600 dark:text-green-400"
            >
                {{ status }}
            </div>

            <ErrorFeedback :message="form.errors.email" />

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
                        placeholder="m@example.com"
                        required
                        autofocus
                    />
                </div>

                <Button
                    type="submit"
                    class="w-full"
                    :disabled="form.processing"
                >
                    Send
                </Button>

                <div class="text-center text-sm">
                    Did you remember?
                    <Link
                        :href="route('login')"
                        class="underline underline-offset-4"
                    >
                        Log in
                    </Link>
                </div>
            </div>
        </form>
    </AuthenticationLayout>
</template>
