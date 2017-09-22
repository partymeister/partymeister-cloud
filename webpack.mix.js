const mix = require('laravel-mix');

mix.options({ processCssUrls: false });

//app.scss includes app css, Bootstrap and Ionicons
mix.sass('./resources/assets/sass/app.scss', 'public/css')
    .less('./node_modules/admin-lte/build/less/AdminLTE.less', './public/css/adminlte-less.css')
    // .less('adminlte-app.less')
    .less('./node_modules/toastr/toastr.less', 'public/css')
    .combine([
        './public/css/toastr.css',
        './public/css/app.css',
        // './node_modules/animate.css/animate.css',
        // '../css/awesome-bootstrap-checkbox.css',
        './node_modules/select2/dist/css/select2.css',
        './node_modules/admin-lte/dist/css/skins/_all-skins.css',
        './public/css/adminlte-less.css',
        './node_modules/icheck/skins/square/blue.css',
        './public/css/motor/backend.css',
        './public/css/motor/project.css',
        './node_modules/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css'
    ], 'public/css/all.css')
    .copy('node_modules/admin-lte/dist/img/boxed-bg.jpg','public/img')
    .copy('node_modules/font-awesome/fonts/*.*', 'public/fonts/')
    .copy('node_modules/ionicons/dist/fonts/*.*', 'public/fonts/')
    .copy('node_modules/admin-lte/bootstrap/fonts/*.*', 'public/fonts/bootstrap')
    // .copy('node_modules/admin-lte/dist/css/skins/*.*','public/css/skins')
    // .copy('node_modules/admin-lte/dist/img','public/img')
    // .copy('node_modules/admin-lte/plugins','public/plugins')
    .copy('node_modules/icheck/skins/square/blue.png', 'public/css')
    .copy('node_modules/icheck/skins/square/blue@2x.png', 'public/css')
    .copy('node_modules/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js', 'public/js')
    .copy('node_modules/moment/min/moment-with-locales.min.js', 'public/js')


/* Optional: uncomment for bootstrap fonts */
// mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/','public/fonts/bootstrap');

if (mix.config.inProduction) {
    mix.version();
}