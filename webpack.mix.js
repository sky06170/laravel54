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

mix.autoload({
	jquery: ['$', 'window.jQuery', 'jQuery', 'jquery'],
	vue: ['Vue', 'window.Vue'],
	axios: ['axios', 'window.axios']
});

mix.js('resources/assets/js/app.js', 'public/js')
   .sass('resources/assets/sass/app.scss', 'public/css');

mix.js('resources/assets/js/app-custom.js', 'public/js')
   .extract(['lodash','jquery','axios','vue']);
