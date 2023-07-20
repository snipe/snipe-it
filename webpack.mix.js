const mix = require("laravel-mix");

// This generates a file called app.css, which we use
// later on to build all.css
mix
  .options({
    processCssUrls: false,
    processFontUrls: true,
    clearConsole: false,
  })
  .less("./node_modules/admin-lte/build/less/AdminLTE.less", "css/build")
  .less("./resources/assets/less/app.less", "css/build")
  .less("./resources/assets/less/overrides.less", "css/build")
  .styles(
    [

      "./node_modules/bootstrap/dist/css/bootstrap.css",
      "./node_modules/@fortawesome/fontawesome-free/css/all.css",
      "./public/css/build/AdminLTE.css",
      "./node_modules/jquery-ui-bundle/jquery-ui.css",
      "./node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.standalone.css",
      "./node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css",
      "./node_modules/blueimp-file-upload/css/jquery.fileupload.css",
      "./node_modules/blueimp-file-upload/css/jquery.fileupload-ui.css",
      "./node_modules/ekko-lightbox/dist/ekko-lightbox.css",
      "./node_modules/bootstrap-table/dist/bootstrap-table.css",
      "./public/css/build/app.css",
      "./node_modules/select2/dist/css/select2.css",
      "./public/css/build/overrides.css",
    ],
    "./public/css/dist/all.css"
  )
  .version();


/**
 * Copy, minify and version signature-pad.css
 */
mix
  .copy("./resources/assets/css/signature-pad.css", "./public/css/dist")
  .minify("./public/css/dist/signature-pad.css");

/**
 * Copy, minify and version signature-pad.css
 */
mix
    .copy("./node_modules/@fortawesome/fontawesome-free/webfonts", "./public/css/webfonts")

// Combine main SnipeIT JS files
mix
  .js(
    [
      "./resources/assets/js/vue.js", // require()s vue, and require()s bootstrap.js
      "./resources/assets/js/snipeit.js", //this is the actual Snipe-IT JS
      "./resources/assets/js/snipeit_modals.js",
    ],
    "./public/js/build/app.js" //because of compiling - this does not work very well :(
  )
  .vue();

// Convert the skins to CSS
mix.less(
  "./resources/assets/less/skins/skin-blue.less",
  "css/dist/skins",
  "./public/css/dist/skins/skin-blue.css"
);
mix.less(
  "./resources/assets/less/skins/skin-red.less",
  "css/dist/skins",
  "./public/css/dist/skins/skin-red.css"
);
mix.less(
  "./resources/assets/less/skins/skin-contrast.less",
  "css/dist/skins",
  "./public/css/dist/skins/skin-contrast.css"
);
mix.less(
  "./resources/assets/less/skins/skin-green.less",
  "css/dist/skins",
  "./public/css/dist/skins/skin-green.css"
);
mix.less(
  "./resources/assets/less/skins/skin-green-dark.less",
  "css/dist/skins",
  "./public/css/dist/skins/skin-green-light.css"
);
mix.less(
  "./resources/assets/less/skins/skin-black.less",
  "css/dist/skins",
  "./public/css/dist/skins/skin-black.css"
);
mix.less(
  "./resources/assets/less/skins/skin-black-dark.less",
  "css/dist/skins",
  "./public/css/dist/skins/skin-black-light.css"
);
mix.less(
  "./resources/assets/less/skins/skin-red-dark.less",
  "css/dist/skins",
  "./public/css/dist/skins/skin-red-light.css"
);
mix.less(
  "./resources/assets/less/skins/skin-purple.less",
  "css/dist/skins",
  "./public/css/dist/skins/skin-purple.css"
);
mix.less(
  "./resources/assets/less/skins/skin-purple-dark.less",
  "css/dist/skins",
  "./public/css/dist/skins/skin-purple-light.css"
);
mix.less(
  "./resources/assets/less/skins/skin-yellow.less",
  "css/dist/skins",
  "./public/css/dist/skins/skin-yellow.css"
);
mix.less(
  "./resources/assets/less/skins/skin-yellow-dark.less",
  "css/dist/skins",
  "./public/css/dist/skins/skin-yellow-light.css"
);
mix.less(
  "./resources/assets/less/skins/skin-blue-dark.less",
  "css/dist/skins",
  "./public/css/dist/skins/skin-blue-light.css"
);
mix.less(
  "./resources/assets/less/skins/skin-orange-dark.less",
  "css/dist/skins",
  "./public/css/dist/skins/skin-orange-light.css"
);
mix.less(
  "./resources/assets/less/skins/skin-orange.less",
  "css/dist/skins",
  "./public/css/dist/skins/skin-orange.css"
);

/**
 * Combine bootstrap table css
 */
mix
  .combine(
    [
      "./node_modules/bootstrap-table/dist/bootstrap-table.css",
      "./node_modules/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.css",
    ],
    "public/css/dist/bootstrap-table.css"
  )
  .version();

/**
 * Combine JS
 */
mix.combine(
  [
    // lots of node_modules here - should this be subsumed by require()?
    "./node_modules/jquery/dist/jquery.js",
    "./node_modules/select2/dist/js/select2.full.min.js",
    "./node_modules/admin-lte/dist/js/adminlte.min.js",
    "./node_modules/tether/dist/js/tether.js",
    "./node_modules/jquery-ui-bundle/jquery-ui.js",
    "./node_modules/jquery-slimscroll/jquery.slimscroll.js",
    "./node_modules/jquery.iframe-transport/jquery.iframe-transport.js",
    "./node_modules/blueimp-file-upload/js/jquery.fileupload.js",
    "./node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js",
    "./node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js",
    "./node_modules/ekko-lightbox/dist/ekko-lightbox.js",
    "./resources/assets/js/extensions/pGenerator.jquery.js",
    "./node_modules/chart.js/dist/Chart.js",
    "./resources/assets/js/signature_pad.js",
    "./node_modules/jquery-form-validator/form-validator/jquery.form-validator.js", //problem?
    "./node_modules/list.js/dist/list.js",
  ],
  "public/js/build/vendor.js" // this file seems OK!
);

/**
 * Combine bootstrap table js
 */
mix
  .combine(
        [
            './node_modules/bootstrap-table/dist/bootstrap-table.js',
            './node_modules/bootstrap-table/dist/extensions/mobile/bootstrap-table-mobile.js',
            './node_modules/bootstrap-table/dist/extensions/export/bootstrap-table-export.js',
            './node_modules/bootstrap-table/dist/extensions/cookie/bootstrap-table-cookie.js',
            './resources/assets/js/extensions/jquery.base64.js',
            './node_modules/tableexport.jquery.plugin/tableExport.min.js',
            './node_modules/tableexport.jquery.plugin/libs/jsPDF/jspdf.umd.min.js',
            './resources/assets/js/FileSaver.min.js',
            './node_modules/xlsx/dist/xlsx.core.min.js',
            './node_modules/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.js',
            './node_modules/bootstrap-table/dist/extensions/toolbar/bootstrap-table-toolbar.js'
        ],
        'public/js/dist/bootstrap-table.js'
 ).version();

mix
  .combine(
    ["./public/js/build/vendor.js", "./public/js/build/app.js"],
    "./public/js/dist/all.js"
  )
  .version();

/**
 * Copy, minify and version skins
 */
mix
  .minify([
    "./public/css/dist/skins/skin-green.css",
    "./public/css/dist/skins/skin-green-dark.css",
    "./public/css/dist/skins/skin-black.css",
    "./public/css/dist/skins/skin-black-dark.css",
    "./public/css/dist/skins/skin-blue.css",
    "./public/css/dist/skins/skin-blue-dark.css",
    "./public/css/dist/skins/skin-yellow.css",
    "./public/css/dist/skins/skin-yellow-dark.css",
    "./public/css/dist/skins/skin-red.css",
    "./public/css/dist/skins/skin-red-dark.css",
    "./public/css/dist/skins/skin-purple.css",
    "./public/css/dist/skins/skin-purple-dark.css",
    "./public/css/dist/skins/skin-orange.css",
    "./public/css/dist/skins/skin-orange-dark.css",
    "./public/css/dist/skins/skin-contrast.css",
  ])
  .version();
