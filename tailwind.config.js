import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                void: '#0B0A18',
                panel: '#120F26',
                card: '#171332',
                ivory: '#F4F2FA',
                mist: '#9993B8',
                cyan: '#3FD8E0',
                violet: '#9C8CFF',
                pink: '#F17BC4',
                hairline: '#2A2650',
            },
        },
    },
    plugins: [forms],
};