<script setup lang="ts">
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Props {
    className?: string;
}

defineProps<Props>();

const confirmingUserDeletion = ref(false);
const passwordInput = ref<HTMLInputElement>();

const form = useForm({
    password: '',
});

function confirmUserDeletion() {
    confirmingUserDeletion.value = true;
}

function deleteUser(e: Event) {
    e.preventDefault();

    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
        },
    });
}

function closeModal() {
    confirmingUserDeletion.value = false;
    form.clearErrors();
    form.reset();
}
</script>

<template>
    <section :class="`flex max-w-xl flex-col gap-6 ${className}`">
        <header class="flex flex-col gap-2">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Delete Account
            </h2>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Once your account is deleted, all of its resources and data will
                be permanently deleted. Before deleting your account, please
                download any data or information that you wish to retain.
            </p>
        </header>

        <Button
            variant="destructive"
            class="w-fit"
            @click="confirmUserDeletion"
        >
            Delete Account
        </Button>
    </section>

    <Dialog
        :open="confirmingUserDeletion"
        @update:open="(open) => !open && closeModal()"
    >
        <DialogContent>
            <DialogTitle
                class="text-lg font-medium text-gray-900 dark:text-gray-100"
            >
                Are you sure you want to delete your account?
            </DialogTitle>

            <DialogDescription class="text-sm text-gray-600 dark:text-gray-400">
                Once your account is deleted, all of its resources and data will
                be permanently deleted. Please enter your password to confirm
                you would like to permanently delete your account.
            </DialogDescription>

            <form @submit="deleteUser" class="flex flex-col gap-4">
                <div class="flex flex-col gap-2">
                    <Label for="password">Password</Label>

                    <Input
                        id="password"
                        v-model="form.password"
                        type="password"
                        placeholder="••••••••"
                        ref="passwordInput"
                    />

                    <p
                        v-if="form.errors.password"
                        class="mt-2 text-sm text-red-600 dark:text-red-400"
                    >
                        {{ form.errors.password }}
                    </p>
                </div>

                <div class="mt-6 flex justify-end gap-4">
                    <Button type="button" variant="ghost" @click="closeModal">
                        Cancel
                    </Button>

                    <Button
                        type="submit"
                        variant="destructive"
                        :disabled="form.processing"
                    >
                        Delete Account
                    </Button>
                </div>
            </form>
        </DialogContent>
    </Dialog>
</template>
