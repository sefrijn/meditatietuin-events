module.exports = {
  mode: 'jit',
  prefix: 't-',
  purge: {
    content: [
      'templates/**/*.php',
      'styles/**/*.scss',
    ],

  },
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
