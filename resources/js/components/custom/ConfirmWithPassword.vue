<script setup lang="ts">
import ErrorFeedback from '@/components/custom/ErrorFeedback.vue';
import { Button } from '@/components/ui/button';
import {
    Dialog,
    DialogContent,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import axios from 'axios';
import { ref } from 'vue';

interface Props {
    onConfirm: (password: string) => void;
    title?: string;
    description?: string;
}

const props = withDefaults(defineProps<Props>(), {
    title: 'Confirm Password',
    description: 'For your security, please confirm your password to continue.',
});

const confirmingPassword = ref(false);
const error = ref('');
const processing = ref(false);
const password = ref('');

async function startConfirmingPassword() {
    const response = await axios.get(route('password.confirmation'));
    if (response.data.confirmed) {
        props.onConfirm(password.value);
    } else {
        confirmingPassword.value = true;
    }
}

async function confirmPassword() {
    processing.value = true;

    try {
        await axios.post(route('password.confirm'), {
            password: password.value,
        });
        closeModal();
        props.onConfirm(password.value);
    } catch (e: unknown) {
        processing.value = false;
        if (axios.isAxiosError(e) && e.response) {
            error.value = e.response.data.message;
        } else {
            error.value = 'An unexpected error occurred';
        }
    }
}

function closeModal() {
    confirmingPassword.value = false;
    password.value = '';
    error.value = '';
    processing.value = false;
}

function handleKeyup(e: KeyboardEvent) {
    if (e.key === 'Enter') {
        confirmPassword();
    }
}
</script>

<template>
    <div @click="startConfirmingPassword" class="w-fit">
        <slot />
    </div>

    <Dialog
        v-model:open="confirmingPassword"
        @update:open="
            (open) => {
                if (!open) closeModal();
            }
        "
    >
        <DialogContent>
            <DialogHeader>
                <DialogTitle>{{ title }}</DialogTitle>
            </DialogHeader>

            <div class="flex flex-col gap-4">
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ description }}
                </p>

                <div class="flex flex-col gap-2">
                    <Label for="password">Password</Label>
                    <Input
                        type="password"
                        id="password"
                        v-model="password"
                        autocomplete="current-password"
                        @keyup="handleKeyup"
                    />
                </div>

                <ErrorFeedback :message="error" />
            </div>

            <DialogFooter>
                <Button variant="outline" @click="closeModal">Cancel</Button>
                <Button @click="confirmPassword" :disabled="processing">
                    Confirm
                </Button>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
