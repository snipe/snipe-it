
const { mix } = require('laravel-mix');


mix.less('resources/assets/less/app.less', 'public/build')
    .less('resources/assets/less/AdminLTE.less', 'public/build')
    .less('resources/assets/less/overrides.less', 'public/build')
    .copy('./bower_components/bootstrap-less/assets/fonts/bootstrap/*', 'public/fonts')
    .copy('./bower_components/font-awesome/fonts/*', 'public/fonts')
    .options(
        {
        processCssUrls: false,
            uglify: {
                compress: false,
            }

    })


.styles([
    'public/build/app.css',
    'public/build/AdminLTE.css',
    './bower_components/iCheck/skins/minimal/minimal.css',
    './bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css',
    'public/build/overrides.css',

], 'public/css/dist/all.css')

//mix.version('public/css/all.css', 'public/css');


.js(
    // jQuery is loaded from vue.js webpack process
    './resources/assets/js/vue.js', //this is Snipe-IT's initializer for Vue.js
    'public/build'
)

.scripts([
    'public/build/vue.js', //this is the modularized nifty Vue.js thing we just built, above!
    './bower_components/tether/dist/js/tether.min.js',
    './bower_components/jquery-ui/jquery-ui.js',
    './bower_components/jquery-slimscroll/jquery.slimscroll.js',
    './bower_components/jquery.iframe-transport/jquery.iframe-transport.js',
    './bower_components/blueimp-file-upload/js/jquery.fileupload.js',
    './bower_components/fastclick/lib/fastclick.js',
    './bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js',
    './bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
    './bower_components/iCheck/icheck.js',
    './bower_components/select2/dist/js/select2.full.js',
    './bower_components/ekko-lightbox/dist/ekko-lightbox.js',
    './resources/assets/js/app.js', //this is part of AdminLTE
    './resources/assets/js/snipeit.js', //this is the actual Snipe-IT JS



],'public/js/dist/all.js');

if (mix.config.inProduction) {
    mix.version();
}


