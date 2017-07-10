const {mix} = require('laravel-mix');
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
mix.webpackConfig({

});

mix.js('resources/assets/js/app.js', 'public/js').extract([
  'element-ui',
  'vue-quill-editor',
  'vue-router',
  'bootstrap-sass',
  'lodash',
  'sweetalert',
  'vue-multiselect'
]).sass('resources/assets/sass/app.scss', 'public/css')
   .version();