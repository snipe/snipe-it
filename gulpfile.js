var elixir = require('laravel-elixir');
require('laravel-elixir-codeception');
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
    //mix.sass(['app.scss','bootstrap-overrides.scss'],'public/assets/css');
    mix.less(['overrides.less'],'public/assets/css');
    mix.version('assets/css/app.css');

    mix.scripts([
        'snipeit.js',
        'app.js'

    ],'public/assets/js');


  //  mix.codeception();



});
