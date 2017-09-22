/*!
 * Bootstrap Colorpicker v2.4.0
 * https://itsjavi.com/bootstrap-colorpicker/
 *
 * Originally written by (c) 2012 Stefan Petre
 * Licensed under the Apache License v2.0
 * http://www.apache.org/licenses/LICENSE-2.0.txt
 *
 */

(function(factory) {
  var global = (typeof window === 'undefined') ? this : window;

  if (typeof exports === 'object') {
    module.exports = factory(global.jQuery, global);
  } else if (typeof define === 'function' && define.amd) {
    define(['jquery'], function(jq) {
      return factory(jq, global);
    });
  } else if (global.jQuery && !global.jQuery.fn.colorpicker) {
    factory(global.jQuery, global);
  }
}(function(jQuery, window) {
  'use strict';

  var $ = jQuery;

  //@colorpicker-color
  //@colorpicker-defaults
  //@colorpicker-component
}));
