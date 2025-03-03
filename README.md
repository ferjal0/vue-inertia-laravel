# Vue Inertia Laravel - Project Starter

A modern, full-stack web application boilerplate built with Laravel 12, Inertia.js, Vue 3 (with Composition API), TypeScript, Tailwind CSS, and Shadcn UI components.

![Starter Screenshots](https://github.com/user-attachments/assets/0e06b0b9-36bb-4e0d-acb7-b192dbde299d)

## Features

- **Modern Vue 3 with Composition API**
    - Explicit reactivity with `ref`, `reactive`, and `computed`
    - Type-safe props with `defineProps`
    - Improved component composition with `defineComponent`
- **Full-Stack Integration**
    - Laravel 12 backend with robust authentication via Fortify
    - Seamless frontend-backend communication with Inertia.js
    - Server-side rendering for optimal performance
- **Developer Experience**
    - Hot Module Replacement (HMR) and fast refresh
    - TypeScript with strict type checking
    - Modern UI powered by Tailwind CSS and Shadcn
    - Comprehensive ESLint and Prettier configuration

## Architecture Overview

This project implements a modern monolithic architecture using Laravel as the backend framework and Vue 3 for the frontend, seamlessly connected via Inertia.js. This architecture provides:

- **Single Codebase**: All code lives in one repository, simplifying deployment and maintenance
- **Modern Reactivity**: Vue 3's Composition API for explicit and powerful state management
- **Type Safety**: Full TypeScript support with improved type inference
- **Modern UI**: Powered by Tailwind CSS and Shadcn components
- **Authentication**: Built-in auth system using Laravel Fortify
- **Developer Experience**: Enhanced development workflow with Composition API and TypeScript

### Tech Stack

- **Backend**

    - Laravel 12.x (PHP 8.x)
    - Laravel Fortify for Auth features
    - SQLite

- **Frontend**

    - Vue 3.x with Composition API
    - TypeScript 5.7.3
    - Vite 6.0.11
    - Tailwind CSS
    - Shadcn UI Components
    - Lucide Vue Icons

- **Frontend-Backend communication**
    - Inertia.js for seamless frontend-backend communication

## Getting Started

### Prerequisites

- PHP 8.x
- Composer
- Node.js (Latest LTS version)
- SQLite (but you can use any other RDBMS)
- Laravel Herd (to run the application)

### Installation

1. Clone the repository:

```bash
git clone https://github.com/ferjal0/vue-inertia-laravel
cd vue-inertia-laravel
```

2. Install PHP dependencies:

```bash
composer install
```

3. Install Node.js dependencies:

```bash
pnpm install
```

4. Set up your environment:

```bash
cp .env.example .env
php artisan key:generate
```

5. Configure your database in `.env` and run migrations:

```bash
php artisan migrate
```

6. Start the development servers:

```bash
pnpm run dev
```

Visit `http://vue-inertia-laravel.test` to see your application.

## Documentation Structure

The documentation is split into three main sections:

1. [Getting Started](docs/getting-started.md) - This file, containing project overview and setup instructions
2. [Backend Documentation](docs/backend.md) - Details about Laravel implementation, API endpoints, and authentication
3. [Frontend Documentation](docs/frontend.md) - Vue components, Inertia.js integration, and UI architecture

## Code Style

- PHP code follows PSR-12 standards
- TypeScript/Vue code follows the project's ESLint and Prettier configuration
- Run style checks with:

```bash
# PHP
./vendor/bin/pint

# TypeScript/Vue
pnpm run lint
```

## Building for Production

```bash
pnpm run build
```
