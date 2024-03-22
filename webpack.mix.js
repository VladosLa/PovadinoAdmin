const mix = require('laravel-mix');

mix.postCss('resources/css/app.css', 'public/css', [
      // Подключите необходимые плагины postcss, например, autoprefixer
]);

mix.js('resources/js/app.js', 'public/js/app.js', [

]);
