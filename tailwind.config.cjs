/** @type {import('tailwindcss').Config} */
module.exports = {
	content: [
		'./*.php',
		'./inc/**/*.php',
		'./partials/**/*.php',
		'./templates/**/*.php',
		'./assets/src/js/**/*.js',
		'./assets/src/scss/**/*.{scss,css}',
	],
	theme: {
		extend: {
			colors: {
				primary: 'rgb(var(--auriel-color-primary-rgb, 59 130 246) / <alpha-value>)',
				secondary: 'rgb(var(--auriel-color-secondary-rgb, 251 191 36) / <alpha-value>)',
				accent: 'rgb(var(--auriel-color-accent-rgb, 16 185 129) / <alpha-value>)',
				surface: 'rgb(var(--auriel-color-surface-rgb, 255 255 255) / <alpha-value>)',
				text: 'rgb(var(--auriel-color-text-rgb, 15 23 42) / <alpha-value>)',
			},
		},
	},
	plugins: [],
};
