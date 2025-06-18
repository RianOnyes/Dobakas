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
                // New primary color scheme
                'berkah': {
                    'primary': '#096B68',      // Darkest - for headers, buttons
                    'secondary': '#129990',    // Medium - for accents, hover states
                    'accent': '#90D1CA',       // Light - for highlights, badges
                    'cream': '#FFFBDE',        // Lightest - for backgrounds, cards
                },
                // Legacy colors for backward compatibility
                'berkah-krem': '#FFFBDE',
                'berkah-mint': '#90D1CA',
                'berkah-teal': '#129990',
                'berkah-teal-gelap': '#129990',
                'berkah-hijau-gelap': '#096B68',
            },
            backgroundImage: {
                'gradient-berkah': 'linear-gradient(135deg, #096B68 0%, #129990 50%, #90D1CA 100%)',
                'gradient-berkah-light': 'linear-gradient(135deg, #90D1CA 0%, #FFFBDE 100%)',
                'gradient-berkah-dark': 'linear-gradient(135deg, #096B68 0%, #129990 100%)',
                'gradient-berkah-soft': 'linear-gradient(45deg, #FFFBDE 0%, #90D1CA 50%, #129990 100%)',
                'gradient-berkah-radial': 'radial-gradient(ellipse at center, #90D1CA 0%, #129990 50%, #096B68 100%)',
            }
        },
    },

    plugins: [forms],
};
