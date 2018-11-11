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

mix.webpackConfig({
  output: {
    publicPath: "/",
    chunkFilename: 'js/[name].[chunkhash].js'
  },
});

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
  .js('resources/js/admin/app.js', 'public/admin/js')
  .sass('resources/sass/admin/app.scss', 'public/admin/css')
  .version();
