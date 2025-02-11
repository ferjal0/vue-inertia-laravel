<script setup lang="ts">
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import TwoFactorAuthenticationForm from './Partials/TwoFactorAuthenticationForm.vue';

interface Props {
    isTwoFactorAuthenticationFeatureEnabled: boolean;
}

defineProps<Props>();
</script>

<template>
    <Head>
        <title>Security</title>
    </Head>

    <AuthenticatedLayout>
        <div class="flex max-w-7xl flex-col sm:px-6 lg:px-8">
            <div
                v-if="isTwoFactorAuthenticationFeatureEnabled"
                class="p-4 sm:p-8"
            >
                <TwoFactorAuthenticationForm />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
