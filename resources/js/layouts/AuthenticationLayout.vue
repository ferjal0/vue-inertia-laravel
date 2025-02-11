<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { Command } from 'lucide-vue-next';

defineSlots<{
    default(): any;
}>();
</script>

<template>
    <div class="grid min-h-svh">
        <div class="flex flex-col gap-4 bg-background p-6 md:p-10">
            <div class="flex justify-center gap-2 md:justify-start">
                <Link href="/" class="flex items-center gap-2 font-medium">
                    <div
                        class="flex h-6 w-6 items-center justify-center rounded-md bg-primary text-primary-foreground"
                    >
                        <Command class="size-4" />
                    </div>
                    Vue Inertia Laravel
                </Link>
            </div>
            <div class="flex flex-1 items-center justify-center">
                <div class="w-full max-w-xs">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>
