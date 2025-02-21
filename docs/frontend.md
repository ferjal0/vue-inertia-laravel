# Frontend Documentation

## 🏗️ Frontend Architecture

The frontend is built with Vue 3, TypeScript, and Inertia.js, providing a modern single-page application experience while maintaining the benefits of server-side rendering.

### Directory Structure

```
resources/js/
├── components/     # Reusable UI components
├── layouts/        # Page layouts
├── pages/         # Page components
├── types/         # TypeScript definitions
└── utils/         # Utility functions
```

## 🎨 UI Components

### Shadcn UI Integration

We use Shadcn UI for consistent, accessible components. Components are installed and configured in the `components/ui` directory.

### Custom Components

Custom components using Vue 3 Composition API:

```vue
<!-- resources/js/components/MyComponent.vue -->
<script setup lang="ts">
import { cn } from '@/lib/utils';

interface Props {
    className?: string;
}

const props = defineProps<Props>();
</script>

<template>
    <div :class="cn('base-styles', props.className)">
        <slot />
    </div>
</template>
```

## 🎯 Pages and Routing

### Page Structure

Pages are stored in `resources/js/Pages/` and follow the Laravel route structure:

```
Pages/
├── Auth/
│   ├── Login.vue
│   └── Register.vue
├── Dashboard/
│   └── Index.vue
└── Welcome.vue
```

### Inertia Page Component with Composition API

```vue
<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import type { PageProps } from '@/types';

const props = defineProps<PageProps>();
const count = ref(0);
const doubled = computed(() => count.value * 2);

// Side effects with watch
watch(count, (newValue) => {
    console.log(`Count changed to ${newValue}`);
});
</script>

<template>
    <Head title="Dashboard" />

    <h1>Welcome {{ props.auth.user.name }}</h1>
    <p>Count: {{ count }} (Doubled: {{ doubled }})</p>
</template>
```

## 📐 Layouts

### Layout Structure

Layouts are in `resources/js/layouts/` and provide consistent page structure:

- `AuthenticatedLayout.vue`: For authenticated pages
- `GuestLayout.vue`: For public pages
- `AuthenticationLayout.vue`: For auth-related pages

### Using Layouts with Slots

```vue
<script setup lang="ts">
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h1>Dashboard</h1>
        </template>
        <slot />
    </AuthenticatedLayout>
</template>
```

## 🔄 State Management

### Inertia.js Form Handling with Composition API

```vue
<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
});

function submit() {
    form.post('/login');
}
</script>

<template>
    <form @submit.prevent="submit">
        <input type="email" v-model="form.email" />
        <input type="password" v-model="form.password" />
        <button type="submit" :disabled="form.processing">Login</button>
    </form>
</template>
```

## 🎭 TypeScript Integration

### Type Definitions

```typescript
// resources/js/types/index.ts
export interface User {
    id: number;
    name: string;
    email: string;
}

export interface PageProps {
    auth: {
        user: User;
    };
}
```

## 🔧 Component Props with TypeScript

Props should be typed using TypeScript and Vue 3's Composition API:

```vue
<script setup lang="ts">
interface Props {
    title: string;
    description?: string;
}

const props = defineProps<Props>();

// Computed state from props
const titleLength = computed(() => props.title.length);
</script>

<template>
    <div>
        <h2>{{ title }}</h2>
        <p v-if="description">{{ description }}</p>
        <small>Title length: {{ titleLength }}</small>
    </div>
</template>
```

## 🔍 Key Features of Vue 3 Composition API

- **ref/reactive**: Explicit reactive state declaration
- **defineProps**: Type-safe props with better TypeScript integration
- **computed**: Computed values that update automatically
- **watch/watchEffect**: Side effects that run when dependencies change
- **slots**: Flexible slot system for template composition
