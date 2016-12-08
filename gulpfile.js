var elixir = require('laravel-elixir');
require('laravel-elixir-codeception-standalone');
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
    mix.less(['AdminLTE.less','skins/skin-blue.less','ekko-lightbox.less','overrides.less','fontawesome-animated.css'],'public/assets/css');


    mix.scripts([
        'plugins/jQuery/jQuery-2.1.4.min.js',
        'plugins/jQueryUI/jquery-ui.js',
        'plugins/jQueryUI/jquery.ui.widget.js',
        'plugins/iframe-transport/jquery.iframe-transport.js',
        'plugins/fileupload/jquery.fileupload.js',
        'bootstrap.js',
        'plugins/fastclick/fastclick.js',
        'plugins/slimScroll/jquery.slimscroll.js',
        'plugins/select2/select2.full.min.js',
        'plugins/colorpicker/bootstrap-colorpicker.js',
        'bootstrap-table.js',
        'plugins/datepicker/bootstrap-datepicker.js',
        'plugins/select2/select2.js',
        'plugins/iCheck/icheck.js',
        'ekko-lightbox.js',
        'snipeit.js',
        'app.js'

    ],'public/assets/js');
    mix.version(['assets/css/app.css','assets/js/all.js']);


    mix.codeception(null, { flags: '--report' });



});
