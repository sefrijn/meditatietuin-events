const mix = require('laravel-mix');

mix
  .setPublicPath('./dist')
  .browserSync({
    proxy: 'demeditatietuin.test/',
    files: [
           'templates/**/*',
           'dist/**/*'
    ],
    notify: {
        styles: {
            top: 'auto',
            bottom: '0'
        }
    }
  });

mix
  .sass('styles/style.scss', 'styles')
  .options({
    processCssUrls: false,
    postCss: [
      require('tailwindcss')
    ],
  });

mix
  .js('scripts/app.js', 'scripts');

mix
  .sourceMaps()
  .version();