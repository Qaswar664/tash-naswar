import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import { defineConfig } from 'vite';

// 🔥 Add these
import MotionResolver from 'motion-v/resolver';
import Components from 'unplugin-vue-components/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),

        // 🔥 Motion auto-import support
        Components({
            dts: true,
            resolvers: [MotionResolver()],
        }),
    ],
});
