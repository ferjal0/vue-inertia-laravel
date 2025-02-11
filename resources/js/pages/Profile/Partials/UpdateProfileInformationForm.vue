<script setup lang="ts">
import ErrorFeedback from '@/components/custom/ErrorFeedback.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm, usePage } from '@inertiajs/vue3';
import { Pencil } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { toast } from 'vue-sonner';

interface Props {
    className?: string;
}

defineProps<Props>();

// State
const photoPreview = ref<string | null>(null);

// Refs
const photoInput = ref<HTMLInputElement>();

const page = usePage();
const auth = computed(() => page.props.auth);
const user = computed(() => auth.value.user);

const form = useForm({
    _method: 'PATCH',
    name: user.value.name,
    email: user.value.email,
    photo: null as File | null,
});

function submit(e: Event) {
    e.preventDefault();
    updateProfileInformation();
}

function updateProfileInformation() {
    if (photoInput.value?.files?.[0]) {
        form.photo = photoInput.value.files[0];
    }

    form.post(route('profile.update'), {
        onSuccess: () => {
            toast.success('Profile updated successfully');
            clearPhotoFileInput();
        },
        onError: (errors) => {
            toast.error('Something went wrong', {
                description: JSON.stringify(errors),
            });
        },
    });
}

function selectNewPhoto() {
    photoInput.value?.click();
}

function updatePhotoPreview() {
    const photo = photoInput.value?.files?.[0];

    if (!photo) return;

    const reader = new FileReader();

    reader.onload = (e) => {
        photoPreview.value = e.target?.result as string | null;
    };

    reader.readAsDataURL(photo);
}

function clearPhotoFileInput() {
    if (photoInput.value?.value) {
        photoInput.value.value = '';
    }
}
</script>

<template>
    <section :class="className">
        <header class="flex flex-col gap-2">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Profile Information
            </h2>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit="submit" class="mt-6 space-y-6">
            <div class="col-span-6 sm:col-span-4">
                <!-- Hidden file input for photo upload -->
                <input
                    id="photo"
                    ref="photoInput"
                    name="photo"
                    type="file"
                    class="hidden"
                    @change="updatePhotoPreview"
                    accept="image/*"
                />

                <!-- Current Profile Photo -->
                <div class="flex items-center gap-4">
                    <div class="group relative">
                        <Avatar class="size-20 rounded-lg">
                            <AvatarImage
                                v-if="photoPreview"
                                :src="photoPreview"
                                :alt="form.name"
                            />
                            <AvatarImage
                                v-else-if="user.profile_photo_url"
                                :src="user.profile_photo_url"
                                :alt="form.name"
                            />
                            <AvatarFallback class="rounded-lg text-xl">
                                {{ user.name.substring(0, 2).toUpperCase() }}
                            </AvatarFallback>
                        </Avatar>

                        <!-- Hover Overlay with Edit Button -->
                        <button
                            type="button"
                            class="absolute inset-0 flex size-20 cursor-pointer items-center justify-center rounded-lg bg-black/50 opacity-0 transition-opacity group-hover:opacity-100"
                            @click="selectNewPhoto"
                        >
                            <Pencil class="h-5 w-5 text-white" />
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-span-6 sm:col-span-4">
                <Label for="name">Name</Label>
                <Input
                    id="name"
                    type="text"
                    class="max-w-lg"
                    v-model="form.name"
                    required
                    autocomplete="name"
                />
                <ErrorFeedback :message="form.errors.name" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <Label for="email">Email</Label>
                <Input
                    id="email"
                    type="email"
                    class="max-w-lg"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <ErrorFeedback :message="form.errors.email" />
            </div>

            <div class="flex items-center gap-4">
                <Button type="submit" :disabled="form.processing">Save</Button>
            </div>
        </form>
    </section>
</template>
