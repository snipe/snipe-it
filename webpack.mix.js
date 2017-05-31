
const { mix } = require('laravel-mix');

var bowerPath = './bower_components';

/*
mix.less(
    [
        'app.less',
            bowerPath + '/iCheck/skins/minimal/*',
            'AdminLTE.less',
            'skins/skin-blue.less',
            'overrides.less'
        ], 'public/assets/css/')
        .copy(bowerPath + '/bootstrap-less/assets/fonts/bootstrap/**', 'public/assets/fonts')
        .copy(bowerPath + '/font-awesome/fonts/*', 'public/build/fonts');
*/


mix.js(
        // jQuery is loaded from vue.js webpack process
        './resources/assets/js/vue.js', //this is Snipe-IT's initializer for Vue.js
        // and incidentally, ends up being the name of the result file. weird, right?
        //'./resources/assets/js/vue-dist.js', //this may not be necessary?
        'public/build'
    );

mix.scripts([
    bowerPath + '/tether/dist/js/tether.min.js',
    // //'vue-dist.js', //this seems duplicated to me?
    bowerPath + '/jquery-ui/jquery-ui.js',
    bowerPath + '/jquery-slimscroll/jquery.slimscroll.js',
    bowerPath + '/jquery.iframe-transport/jquery.iframe-transport.js',
    bowerPath + '/blueimp-file-upload/js/jquery.fileupload.js',
    bowerPath + '/fastclick/lib/fastclick.js',
    bowerPath + '/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js',
    bowerPath + '/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
    bowerPath + '/iCheck/icheck.js',
    bowerPath + '/select2/dist/js/select2.full.js',
    bowerPath + '/ekko-lightbox/dist/ekko-lightbox.js',
    './resources/assets/js/snipeit.js', //this is the actual Snipe-IT JS
    'app.js', //this is part of AdminLTE
    'public/build/vue.js', //this is the modularized nifty Vue.js thing we just built, above!

],'public/assets/js/all.js'); 
//mix.version(['assets/css/app.css','assets/js/all.js']);

