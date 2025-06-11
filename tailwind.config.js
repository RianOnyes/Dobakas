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
                'berkah-krem': '#FFFBDE',
                'berkah-mint': '#90D1CA',
                'berkah-teal-gelap': '#129990',
                'berkah-hijau-gelap': '#096B68',
            }
        },
    },

    plugins: [forms],
};
