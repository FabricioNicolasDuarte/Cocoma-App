import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import colors from 'tailwindcss/colors'; // Se importa la paleta de colores de Tailwind

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
                // Aquí está el cambio clave:
                // Redefinimos el color 'indigo' para que use la paleta de colores 'cyan'.
                // Ahora, cualquier clase de Tailwind que use 'indigo' (como focus:ring-indigo-500)
                // mostrará el color turquesa automáticamente.
                indigo: colors.cyan,
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
