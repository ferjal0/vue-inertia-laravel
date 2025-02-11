<script setup lang="ts">
import {
    Collapsible,
    CollapsibleContent,
    CollapsibleTrigger,
} from '@/components/ui/collapsible';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
} from '@/components/ui/sidebar';
import { Link } from '@inertiajs/vue3';
import { ChevronRight } from 'lucide-vue-next';

interface NavItem {
    title: string;
    url: string;
    icon: any;
    isActive?: boolean;
    items?: {
        title: string;
        url: string;
    }[];
}

interface Props {
    items: NavItem[];
}

defineProps<Props>();
</script>

<template>
    <SidebarGroup>
        <SidebarGroupLabel>Platform</SidebarGroupLabel>
        <SidebarMenu>
            <template v-for="mainItem in items" :key="mainItem.url">
                <Collapsible :defaultOpen="false" class="group/collapsible">
                    <SidebarMenuItem>
                        <template v-if="mainItem.items">
                            <CollapsibleTrigger>
                                <SidebarMenuButton as-child>
                                    <template #tooltip>
                                        {{ mainItem.title }}
                                    </template>
                                    <component
                                        v-if="mainItem.icon"
                                        :is="mainItem.icon"
                                    />
                                    <span>{{ mainItem.title }}</span>
                                    <ChevronRight
                                        class="ml-auto transition-transform duration-200 group-data-[state=open]/collapsible:rotate-90"
                                    />
                                </SidebarMenuButton>
                            </CollapsibleTrigger>
                            <CollapsibleContent>
                                <SidebarMenuSub>
                                    <template
                                        v-for="subItem in mainItem.items"
                                        :key="subItem.url"
                                    >
                                        <SidebarMenuSubItem>
                                            <SidebarMenuSubButton as-child>
                                                <Link :href="subItem.url">
                                                    <span>{{
                                                        subItem.title
                                                    }}</span>
                                                </Link>
                                            </SidebarMenuSubButton>
                                        </SidebarMenuSubItem>
                                    </template>
                                </SidebarMenuSub>
                            </CollapsibleContent>
                        </template>
                        <template v-else>
                            <SidebarMenuButton as-child>
                                <Link :href="mainItem.url">
                                    <template #tooltip>
                                        {{ mainItem.title }}
                                    </template>
                                    <component
                                        v-if="mainItem.icon"
                                        :is="mainItem.icon"
                                    />
                                    <span>{{ mainItem.title }}</span>
                                </Link>
                            </SidebarMenuButton>
                        </template>
                    </SidebarMenuItem>
                </Collapsible>
            </template>
        </SidebarMenu>
    </SidebarGroup>
</template>
