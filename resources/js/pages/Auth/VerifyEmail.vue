<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AuthenticationLayout from '@/layouts/AuthenticationLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

interface Props {
    status?: string;
}

defineProps<Props>();

const form = useForm({});

function submit(e: Event) {
    e.preventDefault();
    form.post(route('verification.send'));
}
</script>

<template>
    <Head>
        <title>Verify Email</title>
    </Head>

    <AuthenticationLayout>
        <form class="flex flex-col gap-6" @submit="submit">
            <div class="flex flex-col items-center gap-4 text-center">
                <h1 class="text-2xl font-bold">Verify your email</h1>
                <p class="text-balance text-sm text-muted-foreground">
                    Please verify your email address by clicking the link in the
                    email we sent you. If you haven't received it, we can send a
                    new verification link.
                </p>
            </div>

            <div
                v-if="status === 'verification-link-sent'"
                class="text-center text-sm font-medium text-green-600 dark:text-green-400"
            >
                A new verification link has been sent to your email address.
            </div>

            <div class="grid gap-6">
                <Button
                    type="submit"
                    class="w-full"
                    :disabled="form.processing"
                >
                    Resend verification link
                </Button>

                <div class="text-center text-sm">
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="underline underline-offset-4"
                    >
                        Log out
                    </Link>
                </div>
            </div>
        </form>
    </AuthenticationLayout>
</template>
