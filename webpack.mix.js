const { mix } = require('laravel-mix');

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
    resolve: {
        extensions: [".webpack.js", ".web.js", ".js", ".json", ".less"]
    }
});

mix.js('resources/assets/js/app.js', 'public/js')
    // .js('resources/assets/js/pos.js', 'public/js')
    .sourceMaps()
    .sass('resources/assets/sass/app.scss', 'public/css')
    // .sass('resources/assets/sass/pos.scss','public/css/pos.css')
    .combine([
        'public/css/app.css',
        'node_modules/select2/dist/css/select2.css',
        // 'node_modules/mediaelement/build/mediaelementplayer.css',
        // 'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.css',
        'public/css/motor/backend.css',
        'public/css/motor/project.css',
        // 'resources/assets/css/partymeister/competitions.css',
        'node_modules/@claviska/jquery-minicolors/jquery.minicolors.css',
        'node_modules/medium-editor/dist/css/medium-editor.css',
        'node_modules/medium-editor/dist/css/themes/beagle.css'
    ], 'public/css/all.css')
    .combine([
        'public/css/bootstrap.css',
        'public/css/pos.css'
    ], 'public/css/all-pos.css')
    //APP RESOURCES
    .copy('resources/assets/img/*.*','public/img')
    //VENDOR RESOURCES
    // .copy('node_modules/select2/dist/css/select2.css', 'public/css/select2.css')
    .copy('node_modules/@claviska/jquery-minicolors/jquery.minicolors.png','public/css/')
    .copy('node_modules/medium-editor/dist/js/medium-editor.min.js','public/js/')
    .copy('node_modules/font-awesome/fonts/*.*','public/fonts/')
    .copy('node_modules/simple-line-icons/fonts/*.*','public/fonts/')
    // .copy('node_modules/mediaelement/build/mejs-controls.svg','public/images/vendor/')
    // .copy('node_modules/ionicons/dist/fonts/*.*','public/fonts/')
    // .copy('node_modules/admin-lte/bootstrap/fonts/*.*','public/fonts/bootstrap')
    // .copy('node_modules/admin-lte/dist/css/skins/*.*','public/css/skins')
    // .copy('node_modules/admin-lte/dist/img','public/img')
    // .copy('node_modules/admin-lte/plugins','public/plugins')
    // .copy('node_modules/icheck/skins/square/blue.png','public/css')
    // .copy('node_modules/icheck/skins/square/blue@2x.png','public/css')
    // .copy('node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js', 'public/js')
    .copy('node_modules/moment/min/moment-with-locales.min.js', 'public/js')
;

if (mix.config.inProduction) {
    mix.version();
}
