var elixir = require('laravel-elixir');
require('laravel-elixir-codeception-standalone');
require('laravel-elixir-phpcs');
require('laravel-elixir-vue-2');
var bowerPath = './bower_components';

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */


elixir(function(mix) {

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



    mix.webpack(
            // jQuery is loaded from vue.js webpack process
            './resources/assets/js/vue.js',
            './resources/assets/js/vue-dist.js'
        );




    mix.scripts([
     bowerPath + '/tether/dist/js/tether.js',
        'vue-dist.js',
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
        bowerPath + '/vue-upload-component/dist/vue-upload-component.js',
        'snipeit.js'

    ],'public/assets/js');
    mix.version(['assets/css/app.css','assets/js/all.js']);


    // mix.codeception(null, { flags: '--report' });


    // mix.phpcs([
    //     'app/**/*.php',
    //     'tests/unit/*.php',
    //     'tests/functional/*.php',
    //     'tests/acceptance/*.php'
    // ], {
    //     bin: 'vendor/bin/phpcs',
    //     standard: 'PSR2'
    // });



});


