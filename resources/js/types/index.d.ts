import type { Config } from 'ziggy-js';

declare global {
    namespace App {
        interface User {
            id: number;
            name: string;
            email: string;
            email_verified_at?: string;
            profile_photo_url: string | undefined;
            two_factor_confirmed_at: string | null;
        }

        interface PageProps<
            T extends Record<string, unknown> = Record<string, unknown>,
        > extends T {
            auth: {
                user: User;
            };
            ziggy: Config & { location: string };
        }
    }
}

declare module '@inertiajs/core' {
    interface PageProps extends App.PageProps {}
}

declare module '@inertiajs/vue3' {
    interface PageProps extends App.PageProps {}
    function usePage<TPageProps extends Record<string, unknown> = App.PageProps>(): import('@inertiajs/core').Page<TPageProps>;
}

export {};
