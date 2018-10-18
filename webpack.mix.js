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
    .js('resources/js/welcome.js', 'public/js')
    .js('resources/js/onboarding.js', 'public/js')
    .js('resources/js/account.js', 'public/js')
    .js('resources/js/bank.js', 'public/js')
    .js('resources/js/login.js', 'public/js')
    .js('resources/js/register.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

mix.webpackConfig({
//     This will give you much shorter and more readable imports, like
//      import Android from "icons/Android", rather than
//      import Android from "vue-material-design-icons/Android.vue". Much better!
    resolve: {
        alias : {
          "icons": path.resolve(__dirname, "node_modules/vue-material-design-icons")
        }
      }      
});
