const mix = require('laravel-mix');

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


mix.js('resources/js/app.js', 'public/js')
    .copy('resources/css/bootstrap.min.css', 'public/css')
    .copy('resources/css/calendar.css', 'public/css')
    .copy('resources/css/calendarDark.css', 'public/css')
    .copy('resources/css/admin/calendarDark.css', 'public/css/admin')
    .copy('resources/css/calendarDark2.css', 'public/css')
    .copy('resources/css/admin/calendarDark2.css', 'public/css/admin')
    .copy('resources/css/admin/calendar.css', 'public/css/admin')

    .copy('resources/js/bootstrap.min.js', 'public/js')
    .copy('resources/js/jquery-3.6.0.min.js', 'public/js');
