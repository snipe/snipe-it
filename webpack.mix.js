const { mix } = require("laravel-mix");

// This generates a file called app.css, which we use
// later on to build all.css
mix
  .options({
    processCssUrls: false,
    processFontUrls: true,
    clearConsole: false
  })
  .less("./resources/assets/less/AdminLTE.less", "css/build")
  .less("./resources/assets/less/app.less", "css/build")
  .styles(
    [
      "./node_modules/bootstrap/dist/css/bootstrap.css",
      "./node_modules/font-awesome/css/font-awesome.css",
      "./node_modules/select2/dist/css/select2.css",
      "./public/css/build/AdminLTE.css",
      "./node_modules/jquery-ui-dist/jquery-ui.css",
      "./node_modules/admin-lte/plugins/iCheck/minimal/blue.css",
      "./node_modules/icheck/skins/minimal/minimal.css",
      "./node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.standalone.css",
      "./node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css",
      "./node_modules/blueimp-file-upload/css/jquery.fileupload.css",
      "./node_modules/blueimp-file-upload/css/jquery.fileupload-ui.css",
      "./node_modules/ekko-lightbox/dist/ekko-lightbox.css",
      "./public/css/build/app.css"
    ],
    "./public/css/all.css"
  );

/**
 * Copy, minify and version skins
 */
mix.copyDirectory("./resources/assets/css/skins", "./public/css/skins");
mix
  .minify([
    "./public/css/skins/skin-green-dark.css",
    "./public/css/skins/skin-orange-dark.css",
    "./public/css/skins/skin-red-dark.css"
  ])
  .version();
/**
 * Copy, minify and version signature-pad.css
 */
mix
  .copy("./resources/assets/css/signature-pad.css", "./public/css")
  .minify("./public/css/signature-pad.css")
  .version();

// Combine main SnipeIT JS files
mix.js(
  [
    "./resources/assets/js/vue.js",
    "./resources/assets/js/snipeit.js", //this is the actual Snipe-IT JS
    "./resources/assets/js/snipeit_modals.js"
  ],
  "./public/js/app.js"
);

/**
 * Combine JS
 */
<<<<<<< HEAD
mix.combine([
    './node_modules/jquery-ui-dist/jquery-ui.js',
    './node_modules/admin-lte/dist/js/adminlte.min.js',
    './node_modules/tether/dist/js/tether.min.js',
    './node_modules/jquery-slimscroll/jquery.slimscroll.js',
    './node_modules/jquery.iframe-transport/jquery.iframe-transport.js',
    './node_modules/blueimp-file-upload/js/jquery.fileupload.js',
    './node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js',
    './node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js',
    './node_modules/ekko-lightbox/dist/ekko-lightbox.js',
    './node_modules/icheck/icheck.js',
    './resources/assets/js/extensions/pGenerator.jquery.js',
    './node_modules/chart.js/dist/Chart.js',
    './resources/assets/js/signature_pad.js',
    './resources/assets/js/admin-lte-options.js',
], 'public/js/vendor.js')
.version();
=======
mix
  .combine(
    [
      "./node_modules/admin-lte/dist/js/adminlte.min.js",
      "./node_modules/jquery-ui-dist/jquery-ui.js",
      "./node_modules/tether/dist/js/tether.min.js",
      "./node_modules/jquery-slimscroll/jquery.slimscroll.js",
      "./node_modules/jquery.iframe-transport/jquery.iframe-transport.js",
      "./node_modules/blueimp-file-upload/js/jquery.fileupload.js",
      "./node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js",
      "./node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js",
      "./node_modules/ekko-lightbox/dist/ekko-lightbox.js",
      "./node_modules/icheck/icheck.js",
      "./resources/assets/js/extensions/pGenerator.jquery.js",
      "./node_modules/chart.js/dist/Chart.js",
      "./resources/assets/js/signature_pad.js",
      "./node_modules/jquery-form-validator/form-validator/jquery.form-validator.js"
    ],
    "public/js/vendor.js"
  )
  .version();
>>>>>>> develop

mix.copy(
  [
    "./resources/assets/js/html5shiv.min.js",
    "./resources/assets/js/respond.min.js"
  ],
  "./public/js"
);

/**
 * Combine bootstrap table js
 */
mix
  .combine(
    [
      "node_modules/bootstrap-table/dist/bootstrap-table.js",
      "node_modules/bootstrap-table/dist/extentions/mobile/bootstrap-table-mobile.js",
      "node_modules/bootstrap-table/dist/extensions/export/bootstrap-table-export.js",
      "node_modules/bootstrap-table/dist/extensions/cookie/bootstrap-table-cookie.js",
      "resources/assets/js/extensions/jquery.base64.js",
      "node_modules/tableexport.jquery.plugin/tableExport.js",
      "node_modules/tableexport.jquery.plugin/libs/jsPDF/jspdf.min.js",
      "node_modules/tableexport.jquery.plugin/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"
    ],
    "public/js/dist/bootstrap-table.js"
  )
  .version();
/**
 * Combine bootstrap table js Simple View
 */
mix
  .combine(
    [
      "node_modules/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.js",
      "node_modules/bootstrap-table/dist/extensions/toolbar/bootstrap-table-toolbar.js"
    ],
    "public/js/dist/bootstrap-table-simple-view.js"
  )
  .version();
/**
 * Combine bootstrap table css
 */
mix
  .combine(
    [
      "node_modules/bootstrap-table/dist/bootstrap-table.css",
      "node_modules/bootstrap-table/dist/extensions/sticky-header/bootstrap-table-sticky-header.css"
    ],
    "public/css/dist/bootstrap-table.css"
  )
  .version();
