import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/createQuestion.js',
                'resources/js/removeQuestion.js',
                'resources/js/imagePreview.js',
                'resources/js/toolbarLatext.js',
                'resources/js/submitForm.js',
            ],
            refresh: true,
        }),
    ],
});
