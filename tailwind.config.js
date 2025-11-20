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
            colors: {
                primary: '#06c4a0',
                primaryDark: '#007ee5',
            },

            fontFamily: {
                sans: ['"Nunito Sans"', ...defaultTheme.fontFamily.sans],
                title: ['"Montserrat"', ...defaultTheme.fontFamily.sans],
            },

            animation: {
                'fade-slide': 'fadeSlide 0.8s ease-out',
            },

            keyframes: {
                fadeSlide: {
                    '0%': { opacity: 0, transform: 'translateY(15px)' },
                    '100%': { opacity: 1, transform: 'translateY(0)' },
                },
            },
        },
    },

    plugins: [forms],
};
