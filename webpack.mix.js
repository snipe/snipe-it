
const { mix } = require('laravel-mix');

mix.setPublicPath('build');

mix
    .options(
        {
            processCssUrls: false,
            processFontUrls: false
        })
    .less('resources/assets/less/AdminLTE.less', 'public/css')
    .less('resources/assets/less/app.less', 'public/css')
    .less('resources/assets/less/overrides.less', 'public/css')



mix.styles([
    'public/css/app.css',
    'public/css/AdminLTE.css',
    'resources/assets/css/font-awesome/font-awesome.min.css',
    './bower_components/iCheck/skins/minimal/minimal.css',
    './node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css',
    'public/css/overrides.css',
], 'public/css/dist/all.css');

mix.js(
    // jQuery is loaded from vue.js webpack process
    './resources/assets/js/vue.js', //this is Snipe-IT's initializer for Vue.js
    'public/build'
);

mix.scripts([
    'public/build/vue.js', //this is the modularized nifty Vue.js thing we just built, above!
    './node_modules/tether/dist/js/tether.min.js',
    './bower_components/jquery-ui/jquery-ui.js',
    './bower_components/jquery-slimscroll/jquery.slimscroll.js',
    './bower_components/jquery.iframe-transport/jquery.iframe-transport.js',
    './bower_components/blueimp-file-upload/js/jquery.fileupload.js',
    './node_modules/fastclick/lib/fastclick.js',
    './node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js',
    './node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
    './bower_components/iCheck/icheck.js',
    './bower_components/select2/dist/js/select2.full.js',
    './node_modules/ekko-lightbox/dist/ekko-lightbox.js',
    './resources/assets/js/app.js', //this is part of AdminLTE
    './resources/assets/js/snipeit.js', //this is the actual Snipe-IT JS
],'public/js/dist/all.js');

//if (mix.config.inProduction) {
   //mix.version();
//}


