/**
 * @author: Dennis Hernández
 * @webSite: http://djhvscf.github.io/Blog
 * @version: v1.2.0
 */


(function ($) {
    'use strict';

    $.extend($.fn.bootstrapTable.defaults, {
        flat: false
    });

    var BootstrapTable = $.fn.bootstrapTable.Constructor,
        _initData = BootstrapTable.prototype.initData;

    BootstrapTable.prototype.initData = function (data, type) {
        if( this.options.flat ){
            data = data === undefined ? this.options.data : data;
            data = sd.flatHelper(data);
        }
        _initData.apply(this, [data, type]);
    };

    //Main functions
    var sd = {
        flat: function (element) {
            var result = {};

            function recurse(cur, prop) {
                if (Object(cur) !== cur) {
                    result[prop] = cur;
                } else if ($.isArray(cur)) {
                    for (var i = 0, l = cur.length; i < l; i++) {
                        recurse(cur[i], prop ? prop + "." + i : "" + i);
                        if (l == 0) {
                            result[prop] = [];
                        }
                    }
                } else {
                    var isEmpty = true;
                    for (var p in cur) {
                        isEmpty = false;
                        recurse(cur[p], prop ? prop + "." + p : p);
                    }
                    if (isEmpty) {
                        result[prop] = {};
                    }
                }
            }

            recurse(element, "");
            return result;
        },

        flatHelper: function (data) {
            var flatArray = [],
                arrayHelper = [];
            if (!$.isArray(data)) {
                arrayHelper.push(data);
                data = arrayHelper;
            }
            $.each(data, function (i, element) {
                flatArray.push(sd.flat(element));
            });
            return flatArray;
        }
    };
})(jQuery);
