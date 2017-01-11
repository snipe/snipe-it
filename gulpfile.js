var elixir = require('laravel-elixir');
require('laravel-elixir-codeception-standalone');
require('laravel-elixir-phpcs');
require('laravel-elixir-vue-2');
var bowerPath = './vendor/bower_components';

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
            'AdminLTE.less',
            'skins/skin-blue.less',
            'ekko-lightbox.less',
            'overrides.less',
            'fontawesome-animated.css',
             bowerPath + '/bootstrap-less/assets/stylesheets/**'
         ], 'public/assets/css/')
            .copy(bowerPath + '/bootstrap-less/assets/fonts/bootstrap/**', 'public/assets/fonts');



    mix.webpack(
            './resources/assets/js/vue.js',
            './resources/assets/js/vue-dist.js'
        );




    mix.scripts([
        'vue-dist.js',
        bowerPath + '/bootstrap/dist/js/**',
        bowerPath + '/jquery-slimscroll/**',
        bowerPath + '/jquery-ui/**',
        bowerPath + '/jquery.iframe-transport/**',
        bowerPath + '/fileupload/**',
        bowerPath + '/fastclick/**',
        bowerPath + '/select2/**',
        bowerPath + '/bootstrap-colorpicker/**',
        bowerPath + '/bootstrap-table/**',
        bowerPath + '/bootstrap-datepicker/**',
        bowerPath +  '/iCheck/**',
        bowerPath + '/ekko-lightbox/**',
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


