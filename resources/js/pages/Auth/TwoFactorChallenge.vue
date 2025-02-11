<script setup lang="ts">
import ErrorFeedback from '@/components/custom/ErrorFeedback.vue';
import {
    PinInput,
    PinInputGroup,
    PinInputInput,
} from '@/components/ui/pin-input';
import AuthenticationLayout from '@/layouts/AuthenticationLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ShieldCheck } from 'lucide-vue-next';
import { ref } from 'vue';

const pinInputCode = ref<string[]>([]);
const form = useForm({
    code: '',
});

const handleChange = async () => {
    form.code = pinInputCode.value.join('');
    if (form.code.length !== 6 || form.processing) return;

    form.processing = true;
    form.post(route('two-factor.login.store'), {
        preserveScroll: true,
        preserveState: true,
        onError: () => {
            form.code = '';
            pinInputCode.value = [];
        },
        onFinish: () => {
            form.processing = false;
            form.code = '';
            pinInputCode.value = [];
        },
    });
};
</script>

<template>
    <Head>
        <title>Login</title>
    </Head>

    <AuthenticationLayout>
        <div class="flex flex-col items-center gap-6 text-center">
            <div class="flex flex-col items-center gap-4">
                <ShieldCheck class="size-12" />
                <h1 class="text-2xl font-bold">Two-Factor Authentication</h1>
            </div>

            <PinInput
                v-model="pinInputCode"
                length="6"
                @complete="handleChange"
                autofocus
            >
                <PinInputGroup>
                    <PinInputInput
                        v-for="(id, index) in 6"
                        :key="id"
                        :index="index"
                    />
                </PinInputGroup>
            </PinInput>

            <p class="text-balance text-sm text-muted-foreground">
                Please enter the one-time password from your authenticator app.
            </p>

            <ErrorFeedback :message="form.errors.code" />
        </div>
    </AuthenticationLayout>
</template>
