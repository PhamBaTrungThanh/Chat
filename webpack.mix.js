let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css')
   .sass('resources/assets/sass/preloader.scss', 'public/css')
   .sourceMaps()
   .browserSync({
        proxy: 'chat.localhost',
        host:  'chat.localhost',
        open: 'external',
    });
   // run versioning on production only
if (mix.inProduction()) {
    mix.version();
}
