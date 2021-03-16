const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').vue()
    .postCss('resources/css/app.css', 'public/css', [ ])
    .sass('resources/sass/main.scss', 'public/css/app.scss')
    .sass('resources/sass/autenticacao/registo.scss', 'public/css/autenticacao.css')
    .sass('resources/sass/dashboard/dashboard.scss', 'public/css/dashboard.css');
