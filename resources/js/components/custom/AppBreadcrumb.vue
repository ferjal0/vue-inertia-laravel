<script setup lang="ts">
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from '@/components/ui/breadcrumb';
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

// Remove query parameters and trailing slash
const pathWithoutQuery = computed(() => page.url.split('?')[0]);
const currentPath = computed(() =>
    pathWithoutQuery.value.endsWith('/')
        ? pathWithoutQuery.value.slice(0, -1)
        : pathWithoutQuery.value,
);
const segments = computed(() => currentPath.value.split('/').filter(Boolean));

// Generate breadcrumb segments
const breadcrumbSegments = computed(() =>
    segments.value.length
        ? segments.value.map((segment: string, index: number) => {
              const path = `/${segments.value.slice(0, index + 1).join('/')}`;
              return {
                  title:
                      segment.charAt(0).toUpperCase() +
                      segment.slice(1).replace(/-/g, ' '),
                  url: path,
              };
          })
        : [{ title: 'Dashboard' }],
);
</script>

<template>
    <Breadcrumb>
        <BreadcrumbList>
            <template
                v-for="(segment, index) in breadcrumbSegments"
                :key="segment.title"
            >
                <template v-if="index < breadcrumbSegments.length - 1">
                    <BreadcrumbItem class="hidden md:block">
                        <BreadcrumbLink>{{ segment.title }}</BreadcrumbLink>
                    </BreadcrumbItem>
                    <BreadcrumbSeparator class="hidden md:block" />
                </template>
                <BreadcrumbItem v-else class="hidden md:block">
                    <BreadcrumbPage>{{ segment.title }}</BreadcrumbPage>
                </BreadcrumbItem>
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>
