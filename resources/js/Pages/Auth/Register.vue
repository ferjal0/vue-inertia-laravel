<script setup lang="ts">
import ErrorFeedback from '@/components/custom/ErrorFeedback.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthenticationLayout from '@/layouts/AuthenticationLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';

interface Props {
    isRegisterEnabled: boolean;
}

const props = defineProps<Props>();

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function submit(e: Event) {
    e.preventDefault();
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}

onMounted(() => {
    if (!props.isRegisterEnabled) {
        window.location.href = route('login');
    }
});
</script>

<template>
    <Head>
        <title>Register</title>
    </Head>

    <template v-if="isRegisterEnabled">
        <AuthenticationLayout>
            <form class="flex flex-col gap-6" @submit="submit">
                <div class="flex flex-col items-center gap-2 text-center">
                    <h1 class="text-2xl font-bold">Register your account</h1>
                    <p class="text-balance text-sm text-muted-foreground">
                        Enter your email below to register to your account
                    </p>
                </div>

                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input
                            id="name"
                            type="text"
                            name="name"
                            v-model="form.name"
                            autocomplete="username"
                            placeholder="Enter your name"
                            required
                            autofocus
                        />
                        <ErrorFeedback
                            class="text-center"
                            :message="form.errors.name"
                        />
                    </div>
                </div>

                <div class="grid gap-6">
                    <div class="grid gap-2">
                        <Label for="email">Email</Label>
                        <Input
                            id="email"
                            type="email"
                            name="email"
                            v-model="form.email"
                            autocomplete="username"
                            placeholder="you@example.com"
                            required
                        />
                        <ErrorFeedback
                            class="text-center"
                            :message="form.errors.email"
                        />
                    </div>

                    <div class="grid gap-2">
                        <div class="flex items-center">
                            <Label for="password">Password</Label>
                        </div>
                        <Input
                            id="password"
                            type="password"
                            name="password"
                            v-model="form.password"
                            autocomplete="current-password"
                            placeholder="••••••••"
                            required
                        />
                        <ErrorFeedback
                            class="text-center"
                            :message="form.errors.password"
                        />
                    </div>

                    <div class="grid gap-2">
                        <div class="flex items-center">
                            <Label for="password_confirmation"
                                >Confirm Password</Label
                            >
                        </div>
                        <Input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            v-model="form.password_confirmation"
                            autocomplete="current-password"
                            placeholder="••••••••"
                            required
                        />
                        <ErrorFeedback
                            class="text-center"
                            :message="form.errors.password_confirmation"
                        />
                    </div>

                    <Button
                        type="submit"
                        class="w-full"
                        :disabled="form.processing"
                    >
                        Register
                    </Button>
                </div>

                <div class="flex justify-center gap-1 text-sm">
                    Already have an account?
                    <Link
                        :href="route('login')"
                        class="underline underline-offset-4"
                    >
                        Log in
                    </Link>
                </div>
            </form>
        </AuthenticationLayout>
    </template>
</template>
