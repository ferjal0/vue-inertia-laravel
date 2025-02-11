<script setup lang="ts">
import {
    Command,
    CommandDialog,
    CommandEmpty,
    CommandGroup,
    CommandInput,
    CommandItem,
    CommandList,
    CommandSeparator,
} from '@/components/ui/command';
import { router } from '@inertiajs/vue3';
import { useColorMode } from '@vueuse/core';
import { BadgeCheck, LayoutDashboard, Lock, Moon, Sun } from 'lucide-vue-next';
import { onMounted, ref } from 'vue';

interface NavigationItem {
    title: string;
    href: string;
    icon: typeof Moon;
}

const navigationItems: NavigationItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutDashboard,
    },
    {
        title: 'Profile',
        href: '/account/profile',
        icon: BadgeCheck,
    },
    {
        title: 'Security',
        href: '/account/security',
        icon: Lock,
    },
];

const isOpen = ref(false);

const mode = useColorMode();

onMounted(() => {
    const down = (e: KeyboardEvent) => {
        if (e.key === 'k' && (e.metaKey || e.ctrlKey)) {
            e.preventDefault();
            isOpen.value = !isOpen.value;
        }
    };

    document.addEventListener('keydown', down);
    return () => document.removeEventListener('keydown', down);
});

function goToRoute(href: string) {
    isOpen.value = false;
    router.visit(href);
}

function setTheme(newMode: 'dark' | 'light') {
    isOpen.value = false;
    mode.value = newMode;
}
</script>

<template>
    <CommandDialog v-model:open="isOpen">
        <Command>
            <CommandInput placeholder="Search commands..." />
            <CommandList>
                <CommandEmpty>No results found.</CommandEmpty>
                <CommandGroup heading="Go to...">
                    <CommandItem
                        v-for="item in navigationItems"
                        :key="item.href"
                        :value="item.href"
                        @select="() => goToRoute(item.href)"
                    >
                        <div class="flex items-center gap-2">
                            <component :is="item.icon" class="size-4" />
                            <span>{{ item.title }}</span>
                        </div>
                    </CommandItem>
                </CommandGroup>
                <CommandSeparator />
                <CommandGroup heading="Theme">
                    <CommandItem
                        :value="'dark'"
                        @select="() => setTheme('dark')"
                    >
                        <div class="flex items-center gap-2">
                            <Moon class="size-4" />
                            <span>Dark Mode</span>
                        </div>
                    </CommandItem>
                    <CommandItem
                        :value="'light'"
                        @select="() => setTheme('light')"
                    >
                        <div class="flex items-center gap-2">
                            <Sun class="size-4" />
                            <span>Light Mode</span>
                        </div>
                    </CommandItem>
                </CommandGroup>
            </CommandList>
        </Command>
    </CommandDialog>
</template>
