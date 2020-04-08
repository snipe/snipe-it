
const { mix } = require('laravel-mix');


// // This generates a file called app.css, which we use
// // later on to build all.css
mix
    .options(
        {
            processCssUrls: false,
            processFontUrls: true,
            clearConsole: false
        })
    .less('resources/assets/less/AdminLTE.less', 'css')
    .less('resources/assets/less/app.less', 'css')
    .less('resources/assets/less/overrides.less', 'css')
.styles([
    './resources/assets/css/app.css',
    'public/css/AdminLTE.css',
    'resources/assets/css/font-awesome/font-awesome.min.css',
    './node_modules/icheck/skins/minimal/minimal.css',
    './node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.standalone.css',
    'public/css/bootstrap-tables-sticky-header.css',
    'public/css/overrides.css'
],
    './public/css/dist/all.css')

// jQuery is loaded from vue.js webpack process
// This compiles the vue.js file in the build directory
// for later concatenation in the scripts() section below.
.js(

    'resources/assets/js/vue.js', // Snipe-IT's initializer for Vue.js
    './public/js/build'
).sourceMaps()
.scripts([
    './node_modules/jquery-ui/jquery-ui.js',
    './public/js/build/vue.js', //this is the modularized nifty Vue.js thing we just built, above!
    './node_modules/tether/dist/js/tether.min.js',
    './node_modules/jquery-slimscroll/jquery.slimscroll.js',
    './node_modules/jquery.iframe-transport/jquery.iframe-transport.js',
    './node_modules/blueimp-file-upload/js/jquery.fileupload.js',
    './node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js',
    './node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
    './node_modules/icheck/icheck.js',
    './node_modules/list.js/dist/list.js',
    './node_modules/ekko-lightbox/dist/ekko-lightbox.js',
    './resources/assets/js/app.js', //this is part of AdminLTE
    './resources/assets/js/snipeit.js', //this is the actual Snipe-IT JS

    './resources/assets/js/snipeit_modals.js'
],
    './public/js/dist/all.js');

mix.copy('./public/css/dist/all.css', './public/css/build/all.css').copy('./public/js/dist/all.js', './public/js/build/all.js');

mix.version();

mix.less('resources/assets/less/skins/skin-blue.less', 'css/skins', './public/css/skins/skin-blue.css');
mix.less('resources/assets/less/skins/skin-red.less', 'css/skins', './public/css/skins/skin-red.css');
mix.less('resources/assets/less/skins/skin-contrast.less', 'css/skins', './public/css/skins/skin-contrast.css');
mix.less('resources/assets/less/skins/skin-green.less', 'css/skins', './public/css/skins/skin-green.css');
mix.less('resources/assets/less/skins/skin-green-dark.less', 'css/skins', './public/css/skins/skin-green-light.css');
mix.less('resources/assets/less/skins/skin-black.less', 'css/skins', './public/css/skins/skin-black.css');
mix.less('resources/assets/less/skins/skin-black-dark.less', 'css/skins', './public/css/skins/skin-black-light.css');
mix.less('resources/assets/less/skins/skin-red-dark.less', 'css/skins', './public/css/skins/skin-red-light.css');
mix.less('resources/assets/less/skins/skin-purple.less', 'css/skins', './public/css/skins/skin-purple.css');
mix.less('resources/assets/less/skins/skin-purple-dark.less', 'css/skins', './public/css/skins/skin-purple-light.css');
mix.less('resources/assets/less/skins/skin-yellow.less', 'css/skins', './public/css/skins/skin-yellow.css');
mix.less('resources/assets/less/skins/skin-yellow-dark.less', 'css/skins', './public/css/skins/skin-yellow-light.css');
mix.less('resources/assets/less/skins/skin-blue-dark.less', 'css/skins', './public/css/skins/skin-blue-light.css');
mix.less('resources/assets/less/skins/skin-orange-dark.less', 'css/skins', './public/css/skins/skin-orange-light.css');
mix.less('resources/assets/less/skins/skin-orange.less', 'css/skins', './public/css/skins/skin-orange.css');



