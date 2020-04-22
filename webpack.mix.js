
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
    .less('./node_modules/admin-lte/build/less/AdminLTE.less', 'css/build')
    .less('./resources/assets/less/app.less', 'css/build')
    .less('./resources/assets/less/overrides.less', 'css/build')
    .styles([
            './resources/assets/css/font-awesome/font-awesome.min.css',
            './node_modules/bootstrap/dist/css/bootstrap.css',
            './public/css/build/AdminLTE.css',
            './resources/assets/css/app.css',
            './node_modules/select2/dist/css/select2.css',
            './node_modules/select2/dist/css/select2.css',
            './node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.standalone.css',
            './resources/assets/css/bootstrap-tables-sticky-header.css',
            //'./node_modules/jquery-ui-bundle/jquery-ui.css',
            './resources/assets/css/signature-pad.css',
            './node_modules/icheck/skins/minimal/_all.css',
            './public/css/build/overrides.css'
        ],
        './public/css/dist/all.css')

    // jQuery is loaded from vue.js webpack process
    // This compiles the vue.js file in the build directory
    // for later concatenation in the scripts() section below.
    .js(
        './resources/assets/js/vue.js', // Snipe-IT's initializer for Vue.js
        './public/js/build'
    ).sourceMaps()
    .scripts([
            './public/js/build/vue.js', //this is the modularized nifty Vue.js thing we just built, above!
            //'./node_modules/jquery/dist/jquery.js',
            //'./node_modules/jquery-ui-bundle/jquery-ui.js',
            //'./node_modules/bootstrap/dist/js/bootstrap.js',
            './resources/assets/js/app.js', //this is part of AdminLTE

            './node_modules/tether/dist/js/tether.min.js',
            './node_modules/jquery-slimscroll/jquery.slimscroll.js',
            './node_modules/jquery.iframe-transport/jquery.iframe-transport.js',
            './node_modules/blueimp-file-upload/js/jquery.fileupload.js',
            './node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js',
            './node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
            './node_modules/icheck/icheck.js',
            './node_modules/select2/dist/js/select2.js',
            './node_modules/jquery-form-validator/form-validator/jquery.form-validator.js',
            './node_modules/list.js/dist/list.js',
            './node_modules/ekko-lightbox/dist/ekko-lightbox.js',

            './resources/assets/js/snipeit.js', //this is the actual Snipe-IT JS
            './resources/assets/js/snipeit_modals.js'
        ],
        './public/js/dist/all.js');

// Syntax: mix.copy(from, to);
// mix.copy('./public/css/build/app.css', './public/css/dist/all.css')
//     .copy('./public/js/build/app.js', './public/js/dist/all.js')
     mix.copy('./node_modules/font-awesome/fonts', './public/css/fonts')
        .copy('./node_modules/icheck/skins/minimal', './public/css/dist');

//mix.version();

mix.less('./resources/assets/less/skins/skin-blue.less', 'css/dist/skins', './public/css/dist/skins/skin-blue.css');
mix.less('./resources/assets/less/skins/skin-red.less', 'css/dist/skins', './public/css/dist/skins/skin-red.css');
mix.less('./resources/assets/less/skins/skin-contrast.less', 'css/dist/skins', './public/css/dist/skins/skin-contrast.css');
mix.less('./resources/assets/less/skins/skin-green.less', 'css/dist/skins', './public/css/dist/skins/skin-green.css');
mix.less('./resources/assets/less/skins/skin-green-dark.less', 'css/dist/skins', './public/css/dist/skins/skin-green-light.css');
mix.less('./resources/assets/less/skins/skin-black.less', 'css/dist/skins', './public/css/dist/skins/skin-black.css');
mix.less('./resources/assets/less/skins/skin-black-dark.less', 'css/dist/skins', './public/css/dist/skins/skin-black-light.css');
mix.less('./resources/assets/less/skins/skin-red-dark.less', 'css/dist/skins', './public/css/dist/skins/skin-red-light.css');
mix.less('./resources/assets/less/skins/skin-purple.less', 'css/dist/skins', './public/css/dist/skins/skin-purple.css');
mix.less('./resources/assets/less/skins/skin-purple-dark.less', 'css/dist/skins', './public/css/dist/skins/skin-purple-light.css');
mix.less('./resources/assets/less/skins/skin-yellow.less', 'css/dist/skins', './public/css/skins/dist/skin-yellow.css');
mix.less('./resources/assets/less/skins/skin-yellow-dark.less', 'css/dist/skins', './public/css/dist/skins/skin-yellow-light.css');
mix.less('./resources/assets/less/skins/skin-blue-dark.less', 'css/skins/dist', './public/css/dist/skins/skin-blue-light.css');
mix.less('./resources/assets/less/skins/skin-orange-dark.less', 'css/dist/skins', './public/css/dist/skins/skin-orange-light.css');
mix.less('./resources/assets/less/skins/skin-orange.less', 'css/dist/skins', './public/css/dist/skins/skin-orange.css');


