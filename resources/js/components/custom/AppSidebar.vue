<script setup lang="ts">
import NavMain from '@/components/custom/NavMain.vue';
import NavProjectMembers from '@/components/custom/NavProjectMembers.vue';
import NavSecondary from '@/components/custom/NavSecondary.vue';
import NavUser from '@/components/custom/NavUser.vue';
import ProjectSwitcher from '@/components/custom/ProjectSwitcher.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
} from '@/components/ui/sidebar';
import { LayoutDashboard, LifeBuoy, Send, Shell } from 'lucide-vue-next';

interface Project {
    logo: any;
    title: string;
    subtitle: string;
}

const projects: Project[] = [
    {
        logo: Shell,
        title: 'Starter',
        subtitle: 'Vue - Inertia - Laravel',
    },
];

interface MainNavigationItem {
    title: string;
    url: string;
    icon: any;
    items?: {
        title: string;
        url: string;
    }[];
}

const navMain: MainNavigationItem[] = [
    {
        title: 'Dashboard',
        url: '/dashboard',
        icon: LayoutDashboard,
    },
];

interface SecondaryNavigationItem {
    title: string;
    url: string;
    icon: any;
}

const navSecondary: SecondaryNavigationItem[] = [
    {
        title: 'Support',
        url: '/dashboard',
        icon: LifeBuoy,
    },
    {
        title: 'Feedback',
        url: '/dashboard',
        icon: Send,
    },
];

interface ProjectMember {
    name: string;
    url: string;
    isConnected: boolean;
}

const projectMembers: ProjectMember[] = [
    {
        name: 'Tylor Otwell',
        url: '#',
        isConnected: true,
    },
    {
        name: 'Jonathan Reinink',
        url: '#',
        isConnected: false,
    },
    {
        name: 'Adam Wathan',
        url: '#',
        isConnected: false,
    },
];
</script>

<template>
    <Sidebar variant="inset" collapsible="icon">
        <SidebarHeader>
            <ProjectSwitcher :projects="projects" />
        </SidebarHeader>
        <SidebarContent>
            <NavMain :items="navMain" />
            <NavProjectMembers :members="projectMembers" />
            <NavSecondary :items="navSecondary" class="mt-auto" />
        </SidebarContent>
        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
</template>
