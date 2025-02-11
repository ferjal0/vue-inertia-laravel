<script setup lang="ts">
interface Props {
    message?: string;
    class?: string;
}

defineProps<Props>();
</script>

<template>
    <p
        v-if="message"
        :class="[
            'text-balance text-sm text-red-600 dark:text-red-400',
            $props.class,
        ]"
    >
        {{ message }}
    </p>
</template>
