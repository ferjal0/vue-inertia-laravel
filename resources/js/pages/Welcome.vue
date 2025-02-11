<script setup lang="ts">
import { Ripple } from '@/components/custom/ripple';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { Command } from 'lucide-vue-next';
import { computed } from 'vue';

const page = usePage();
const auth = computed(() => page.props.auth);
</script>

<template>
    <Head>
        <title>Welcome</title>
    </Head>

    <div class="flex h-svh flex-col">
        <header>
            <div
                class="mx-auto flex max-w-7xl items-center justify-between p-6 md:p-10"
            >
                <Link href="/" class="flex items-center gap-2 font-medium">
                    <div
                        class="flex h-6 w-6 items-center justify-center rounded-md bg-primary text-primary-foreground"
                    >
                        <Command class="size-4" />
                    </div>
                    Vue Inertia Laravel
                </Link>

                <nav class="flex items-center gap-4">
                    <template v-if="auth.user">
                        <Link
                            :href="route('dashboard')"
                            class="rounded-md text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Dashboard
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            :href="route('login')"
                            class="rounded-md text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Log in
                        </Link>
                        <Link
                            :href="route('register')"
                            class="rounded-md text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Register
                        </Link>
                    </template>
                </nav>
            </div>
        </header>

        <main class="mx-auto h-full w-full max-w-7xl grow content-center">
            <div
                class="relative flex h-full w-full flex-col items-center justify-center overflow-hidden rounded-lg md:w-full lg:w-full"
            >
                <p
                    class="z-10 whitespace-pre-wrap text-center text-5xl font-medium tracking-tighter text-black dark:text-white"
                >
                    Your landing goes here
                </p>
                <Ripple
                    circle-class="border-[hsl(var(--primary))] bg-[#0000]/15 dark:bg-[#fff]/20 rounded-full"
                />
            </div>
        </main>
    </div>
</template>
