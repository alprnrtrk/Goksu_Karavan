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
      screens: {
        "min-2xl": { min: "1681px" },
        "min-xl": { min: "1441px" },
        "min-lg": { min: "1281px" },
        "min-md": { min: "1025px" },
        "min-sm": { min: "769px" },
        "min-xs": { min: "481px" },
        "2xl": { max: "1680px" },
        "xl": { max: "1440px" },
        "lg": { max: "1280px" },
        "md": { max: "1024px" },
        "sm": { max: "768px" },
        "xs": { max: "480px" },
      },
      transitionTimingFunction: {
        'soft': 'cubic-bezier(0.25, 0.46, 0.45, 0.94)', // smooth and natural
        'smooth': 'cubic-bezier(0.4, 0, 0.2, 1)',       // material-like
        'swift': 'cubic-bezier(0.55, 0.06, 0.68, 0.19)',// fast in, smooth out
        'bounce': 'cubic-bezier(0.34, 1.56, 0.64, 1)',  // bounce end
        'elastic': 'cubic-bezier(0.47, 1.64, 0.41, 0.8)', // elastic pop
      },
      colors: {
        primary: 'rgb(var(--auriel-color-primary-rgb, 59 130 246) / <alpha-value>)',
        secondary: 'rgb(var(--auriel-color-secondary-rgb, 251 191 36) / <alpha-value>)',
        accent: 'rgb(var(--auriel-color-accent-rgb, 16 185 129) / <alpha-value>)',
        surface: 'rgb(var(--auriel-color-surface-rgb, 255 255 255) / <alpha-value>)',
        text: 'rgb(var(--auriel-color-text-rgb, 15 23 42) / <alpha-value>)',
      },
      fontFamily: {
        italianno: ['"Italianno"', 'serif'],
      },
    },
  },
  plugins: [],
};
