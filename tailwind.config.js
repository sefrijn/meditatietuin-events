module.exports = {
  mode: 'jit',
  // prefix: 't-',
  purge: {
    content: [
      'templates/*.php',
      'templates/**/*.php',
      'styles/**/*.scss',
    ],

  },
  darkMode: false, // or 'media' or 'class'
  theme: {
    fontFamily: {
      'sans': ['"Source Sans Pro"', 'sans-serif'],
      'sans-alt': ['"Raleway"', 'sans-serif'],
    },
    extend: {
      colors: {
        'orange-very-dark' : '#D98F5E',
        'orange-dark': '#E5AB86',
        'orange-medium-dark': '#F4C5A7',
        'orange-medium': '#F0D8BB',
        'orange-light': '#FDE8DA',
        'orange-very-light': '#FFF9F4',
        'green-medium': '#D6E8C1',
        'green-dark': '#C8DCB3',
      }
    }
  },
  variants: {
    extend: {},
  },
  plugins: [],
}
