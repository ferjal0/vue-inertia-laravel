<script setup lang="ts">
import { Button } from '@/components/ui/button';
import AuthenticationLayout from '@/layouts/AuthenticationLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { MailOpen } from 'lucide-vue-next';
</script>

<template>
    <Head>
        <title>Password Reset Link Sent</title>
    </Head>

    <AuthenticationLayout>
        <div class="flex flex-col gap-6">
            <div class="flex flex-col items-center gap-4 text-center">
                <div class="rounded-full bg-muted p-3">
                    <MailOpen class="size-6" />
                </div>
                <h1 class="text-2xl font-bold">Check your email</h1>
                <p class="text-balance text-sm text-muted-foreground">
                    We have sent a password reset link to your email address.
                    Please check your inbox and follow the instructions to reset
                    your password.
                </p>
            </div>

            <div class="grid gap-4">
                <Button variant="outline" class="w-full">
                    <Link :href="route('login')">Return to login</Link>
                </Button>

                <div class="text-center text-sm">
                    Didn't receive the email?
                    <Link
                        :href="route('auth.forgot-password')"
                        class="underline underline-offset-4"
                    >
                        Try again
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticationLayout>
</template>
