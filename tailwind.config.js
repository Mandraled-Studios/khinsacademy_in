import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },

        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            white: colors.white,
            gray: colors.gray,
            blueGray: colors.blueGray,
            name: colors.coolGray,
            trueGray: colors.trueGray,
            warmGray: colors.warmGray,
            yellow: colors.yellow,
            orange: colors.orange,
            amber: colors.amber,
            red: colors.red,
            lime: colors.lime,
            emerald: colors.emerald,
            green: colors.green,
            teal: colors.teal,
            cyan: colors.cyan,
            lightBlue: colors.lightBlue,
            indigo: colors.indigo,
            pink: colors.pink,
            rose: colors.rose,
            purple: colors.purple,
            violet: colors.violet,
            fuchsia: colors.fuchsia,
        }
    },

    plugins: [forms, typography],
};