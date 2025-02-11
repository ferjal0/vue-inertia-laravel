<script setup lang="ts">
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuShortcut,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import {
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { ChevronsUpDown, Plus } from 'lucide-vue-next';
import { ref } from 'vue';

interface Project {
    logo: any;
    subtitle: string;
    title: string;
}

interface Props {
    projects: Project[];
}

const props = defineProps<Props>();
const activeProject = ref(props.projects[0]);
</script>

<template>
    <SidebarMenu>
        <SidebarMenuItem>
            <DropdownMenu>
                <DropdownMenuTrigger as-child>
                    <SidebarMenuButton
                        size="lg"
                        class="data-[state=open]:bg-sidebar-accent data-[state=open]:text-sidebar-accent-foreground"
                    >
                        <div
                            class="bg-sidebar-primary text-sidebar-primary-foreground flex aspect-square size-8 items-center justify-center rounded-lg"
                        >
                            <component
                                :is="activeProject.logo"
                                class="size-4"
                            />
                        </div>
                        <div
                            class="grid flex-1 text-left text-sm leading-tight"
                        >
                            <span class="truncate font-semibold">{{
                                activeProject.title
                            }}</span>
                            <span class="truncate text-xs">{{
                                activeProject.subtitle
                            }}</span>
                        </div>
                        <ChevronsUpDown class="ml-auto" />
                    </SidebarMenuButton>
                </DropdownMenuTrigger>
                <DropdownMenuContent
                    class="w-[--radix-dropdown-menu-trigger-width] min-w-56 rounded-lg"
                    align="start"
                    :sideOffset="4"
                >
                    <DropdownMenuLabel class="text-xs text-muted-foreground">
                        Projects
                    </DropdownMenuLabel>
                    <template
                        v-for="(project, index) in projects"
                        :key="project.title"
                    >
                        <DropdownMenuItem
                            @click="activeProject = project"
                            class="gap-2 p-2"
                        >
                            <div
                                class="flex size-6 items-center justify-center rounded-sm border"
                            >
                                <component
                                    :is="project.logo"
                                    class="size-4 shrink-0"
                                />
                            </div>
                            {{ project.title }}
                            <DropdownMenuShortcut>
                                ⌘{{ index + 1 }}
                            </DropdownMenuShortcut>
                        </DropdownMenuItem>
                    </template>
                    <DropdownMenuSeparator />
                    <DropdownMenuItem class="gap-2 p-2">
                        <div
                            class="flex size-6 items-center justify-center rounded-md border bg-background"
                        >
                            <Plus class="size-4" />
                        </div>
                        <div class="font-medium text-muted-foreground">
                            Add project
                        </div>
                    </DropdownMenuItem>
                </DropdownMenuContent>
            </DropdownMenu>
        </SidebarMenuItem>
    </SidebarMenu>
</template>
