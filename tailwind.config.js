/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
  ],
  theme: {
    extend: {
      fontFamily: {
        // Tipografia para navegacion
        amsterdam: 'New Amsterdam',
        urbanist: 'Urbanist',
      },
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

