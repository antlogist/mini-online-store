let mix = require('laravel-mix');

mix.sass('resources/sass/app.scss', 'dist/css/all.css');

mix.js([
    'resources/js/app.js',
], 'dist/js/all.js').vue();
