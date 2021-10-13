const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    mode: 'jit',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            inset: {
                '-0.2': '-0.05rem'
            },
            animation: {
                tilt: 'tilt 10s infinite linear',
            },
            keyframes: {
                tilt: {
                    '0%, 50%, 100%': {
                        transform: 'rotate(0deg)',
                    },
                    '25%': {
                        transform: 'rotate(1deg)',
                    },
                    '75%': {
                        transform: 'rotate(-1deg)',
                    },
                },
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography'), require('@tailwindcss/aspect-ratio')],
};
