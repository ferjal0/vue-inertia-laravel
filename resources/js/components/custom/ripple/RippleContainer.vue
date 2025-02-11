<script setup lang="ts">
import Ripple from './Ripple.vue';
</script>

<template>
    <div class="relative">
        <slot />
        <Ripple />
    </div>
</template>
