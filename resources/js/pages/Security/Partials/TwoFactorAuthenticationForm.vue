<script setup lang="ts">
import ConfirmWithPassword from '@/components/custom/ConfirmWithPassword.vue';
import ErrorFeedback from '@/components/custom/ErrorFeedback.vue';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import {
    PinInput,
    PinInputGroup,
    PinInputInput,
} from '@/components/ui/pin-input';
import { useForm, usePage } from '@inertiajs/vue3';
import axios from 'axios';
import { CheckCircle, Siren } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { toast } from 'vue-sonner';

// State
const enabling = ref(false);
const disabling = ref(false);
const qrCode = ref<string | null>(null);
const recoveryCodes = ref<string[]>([]);
const pinInputCode = ref<string[]>([]);

// Form
const form = useForm({
    code: '',
});

// User data
const page = usePage();
const auth = computed(() => page.props.auth);
const user = computed(() => auth.value.user);
const twoFactorEnabled = ref(user.value.two_factor_confirmed_at !== null);

// Functions
function enableTwoFactorAuthentication() {
    enabling.value = true;

    form.post(route('two-factor.enable'), {
        onSuccess: () => {
            enabling.value = false;
            showQrCode();
        },
    });
}

function showQrCode() {
    axios
        .get(route('two-factor.qr-code'))
        .then((response) => {
            qrCode.value = response.data.svg;
        })
        .then(() => {
            toast.success('2FA QR Code generated');
        });
}

function confirmTwoFactorAuthentication(e: Event) {
    e.preventDefault();
    form.code = pinInputCode.value.join('');

    form.post(route('two-factor.confirm'), {
        errorBag: 'confirmTwoFactorAuthentication',
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            qrCode.value = null;
            twoFactorEnabled.value = true;
            showRecoveryCodes();
            toast.success('2FA successfully enabled');
        },
        onError: () => {
            toast.error('There was an error enabling 2FA');
        },
    });
}

function showRecoveryCodes() {
    axios.get(route('two-factor.recovery-codes')).then((response) => {
        recoveryCodes.value = response.data;
    });
}

function disableTwoFactorAuthentication() {
    disabling.value = true;

    form.delete(route('two-factor.disable'), {
        preserveScroll: true,
        preserveState: true,
        onBefore: () => {
            disabling.value = true;
        },
        onSuccess: () => {
            disabling.value = false;
            twoFactorEnabled.value = false;
            toast.success('2FA successfully disabled');
        },
        onError: () => {
            disabling.value = false;
            twoFactorEnabled.value = true;
            toast.error('There was an error disabling 2FA');
        },
        onFinish: () => {
            disabling.value = false;
        },
    });
}
</script>

<template>
    <section class="flex max-w-xl flex-col gap-6">
        <header class="flex flex-col gap-2">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Two Factor Authentication
            </h2>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Add additional security to your account using two factor
                authentication.
            </p>
        </header>

        <template v-if="!twoFactorEnabled && !qrCode">
            <div class="flex flex-col gap-6">
                <div class="flex items-center gap-4 text-sm">
                    <Siren class="text-red-500" />
                    <h3>
                        Two-factor authentication is not enabled. We recommend
                        enabling it.
                    </h3>
                </div>
                <ConfirmWithPassword
                    title="Enable 2FA"
                    description="To start enabling two-factor authentication, you must confirm your password."
                    @confirm="enableTwoFactorAuthentication"
                >
                    <Button type="button" :disabled="enabling">
                        {{ enabling ? 'Enabling...' : 'Enable' }}
                    </Button>
                </ConfirmWithPassword>
            </div>
        </template>

        <template v-if="qrCode">
            <div class="flex flex-col gap-6">
                <p
                    class="text-balance text-sm font-medium text-gray-900 dark:text-gray-100"
                >
                    To finish enabling two factor authentication, scan the
                    following QR code using your phone's authenticator
                    application or enter the setup key and provide the generated
                    OTP code.
                </p>

                <div class="contrast-200" v-html="qrCode"></div>

                <div class="flex flex-col gap-2">
                    <form @submit="confirmTwoFactorAuthentication">
                        <Label for="code">Code</Label>

                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2">
                                <PinInput
                                    v-model="pinInputCode"
                                    length="6"
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

                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    {{
                                        form.processing
                                            ? 'Confirming...'
                                            : 'Confirm'
                                    }}
                                </Button>
                            </div>
                            <ErrorFeedback :message="form.errors.code" />
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <template v-if="twoFactorEnabled && !qrCode">
            <div class="flex flex-col gap-6">
                <div class="flex items-center gap-4 text-sm">
                    <CheckCircle class="text-green-500" />
                    <h3>You've already enabled 2FA.</h3>
                </div>
                <template v-if="recoveryCodes.length > 0">
                    <div class="flex max-w-xl flex-col gap-4">
                        <div class="text-sm">
                            <span
                                class="font-semibold text-red-600 dark:text-red-400"
                            >
                                Important:
                            </span>
                            These recovery codes will only be shown once. Store
                            them in a secure password manager immediately. They
                            can be used to recover access to your account if
                            your two factor authentication device is lost.
                        </div>

                        <div
                            class="bg-sidebar grid gap-1 rounded-lg p-4 font-mono text-xs"
                        >
                            <div v-for="code in recoveryCodes" :key="code">
                                {{ code }}
                            </div>
                        </div>
                    </div>
                </template>
                <div class="flex gap-4">
                    <ConfirmWithPassword
                        title="Disable 2FA"
                        description="To disable two-factor authentication, you must confirm your password."
                        @confirm="disableTwoFactorAuthentication"
                    >
                        <Button type="button" :disabled="disabling">
                            {{ disabling ? 'Disabling...' : 'Disable' }}
                        </Button>
                    </ConfirmWithPassword>
                </div>
            </div>
        </template>
    </section>
</template>
