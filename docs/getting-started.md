# Getting Started

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- PHP 8.x
- Node.js (LTS version recommended)
- Composer
- Git
- Laravel Herd (recommended for local development)

## 🚀 Installation

1. **Clone the Repository**

```bash
git clone <your-repository-url> your-project-name
cd your-project-name
```

2. **Install PHP Dependencies**

```bash
composer install
```

3. **Install Node.js Dependencies**

```bash
pnpm install
```

4. **Environment Setup**

```bash
cp .env.example .env
php artisan key:generate
```

5. **Configure Your Environment**
   Edit `.env` file with your database and other configuration settings.

6. **Create Database**

```bash
php artisan migrate
```

7. **Build Assets**

```bash
pnpm run dev
```

## 🏃‍♂️ Development Workflow

### Start the Development Server

```bash
pnpm run dev
```

Your application will be available at `http://vue-inertia-laravel.test` (if using Laravel Herd).

### Development Commands

```bash
# Run tests
php artisan test

# Format PHP code
./vendor/bin/pint

# Type check TypeScript and Vue files
pnpm run check

# Vue type check
pnpm run check:vue

# Lint JavaScript/TypeScript/Vue
pnpm run lint

# Format JavaScript/TypeScript/Vue
pnpm run format
```

## 📦 Production Deployment

1. **Optimize Composer**

```bash
composer install --optimize-autoloader --no-dev
```

2. **Build Frontend Assets**

```bash
pnpm run build
```

3. **Cache Configuration**

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🔧 IDE Setup

For the best development experience, we recommend:

- VS Code with these extensions:
    - Volar (Vue Language Features)
    - TypeScript and JavaScript Language Features
    - Tailwind CSS IntelliSense
    - ESLint
    - Prettier

## 🐛 Common Issues

### Hot Module Replacement (HMR)

If HMR is not working:

1. Clear your browser cache
2. Restart Vite development server
3. Check your `vite.config.js` configuration

### TypeScript Errors

Run `pnpm run check` to identify type issues. Common fixes:

- Ensure proper type definitions in `resources/js/types`
- Check for missing type imports
- Verify Vue component prop types

### Vue 3 Composition API Issues

Common issues with Composition API and their solutions:

1. **State Not Updating**
   - Ensure you're using `ref` or `reactive` for reactive variables
   - Check that you're accessing `.value` for refs
   - Verify reactive objects are properly destructured

2. **Props Type Errors**
   - Use `defineProps<T>()` for type-safe props
   - Ensure your interface is properly defined
   - Check that required props are being passed

3. **Computed Values Not Updating**
   - Make sure all dependencies are reactive (`ref` or `reactive`)
   - Verify the computation doesn't have side effects
   - Check that you're accessing `.value` for refs

4. **Watch Not Running**
   - Check that dependencies are actually changing
   - Ensure you're watching the correct source
   - Verify watch options (deep, immediate)

5. **Template Rendering Issues**
   - Check template syntax for Vue 3
   - Verify reactive state is properly referenced
   - Ensure components are properly registered

## 🔒 Type Safety

To ensure type safety across your application:

1. Enable strict mode in `tsconfig.json`
2. Use TypeScript for all new components
3. Properly type your Inertia page props
4. Use `defineProps<T>()` for component props
5. Add return types to all functions
