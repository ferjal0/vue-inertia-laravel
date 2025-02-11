<script setup lang="ts">
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

interface Props {
    isUpdatePasswordEnabled: boolean;
    isUpdateProfileEnabled: boolean;
}

defineProps<Props>();
</script>

<template>
    <Head>
        <title>Profile</title>
    </Head>

    <AuthenticatedLayout>
        <div class="flex max-w-7xl flex-col sm:px-6 lg:px-8">
            <div v-if="isUpdateProfileEnabled" class="p-4 sm:p-8">
                <UpdateProfileInformationForm />
            </div>

            <div v-if="isUpdatePasswordEnabled" class="p-4 sm:p-8">
                <UpdatePasswordForm />
            </div>

            <div class="p-4 sm:p-8">
                <DeleteUserForm />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
