/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
      ],
  theme: {
    extend: {},
    colors: {
        'grey-light' : '#F5F6F9',
        'white' :'#FFFFFFFF',
        'grey' : 'rgba(0,0,0,0.4)',
        'cyan-500' :'#47cdff',
        'cyan-400' :'#8ae2fe',
         'red-700' :'rgb(154 52 18)'
      }
  },
  plugins: [],
}

