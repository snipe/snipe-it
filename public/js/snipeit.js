/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/snipeit.js":
/***/ (function(module, exports) {


/**
 * Module containing core application logic.
 * @param  {jQuery} $        Insulated jQuery object
 * @param  {JSON} settings Insulated `window.snipeit.settings` object.
 * @return {IIFE}          Immediately invoked. Returns self.
 */

lineOptions = {

    legend: {
        position: "bottom"
    },
    scales: {
        yAxes: [{
            ticks: {
                fontColor: "rgba(0,0,0,0.5)",
                fontStyle: "bold",
                beginAtZero: true,
                maxTicksLimit: 5,
                padding: 20
            },
            gridLines: {
                drawTicks: false,
                display: false
            }
        }],
        xAxes: [{
            gridLines: {
                zeroLineColor: "transparent"
            },
            ticks: {
                padding: 20,
                fontColor: "rgba(0,0,0,0.5)",
                fontStyle: "bold"
            }
        }]
    }

};

pieOptions = {
    //Boolean - Whether we should show a stroke on each segment
    segmentShowStroke: true,
    //String - The colour of each segment stroke
    segmentStrokeColor: "#fff",
    //Number - The width of each segment stroke
    segmentStrokeWidth: 1,
    //Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    //Number - Amount of animation steps
    animationSteps: 100,
    //String - Animation easing effect
    animationEasing: "easeOutBounce",
    //Boolean - Whether we animate the rotation of the Doughnut
    animateRotate: true,
    //Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale: false,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: false,

    //String - A legend template
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li>" + "<i class='fa fa-circle-o' style='color: <%=segments[i].fillColor%>'></i>" + "<%if(segments[i].label){%><%=segments[i].label%><%}%> foo</li><%}%></ul>",
    //String - A tooltip template
    tooltipTemplate: "<%=value %> <%=label%> "
};

//-----------------
//- END PIE CHART -
//-----------------


(function ($, settings) {
    var Components = {};
    Components.modals = {};

    // confirm delete modal
    Components.modals.confirmDelete = function () {
        var $el = $('table');

        var events = {
            'click': function click(evnt) {
                var $context = $(this);
                var $dataConfirmModal = $('#dataConfirmModal');
                var href = $context.attr('href');
                var message = $context.attr('data-content');
                var title = $context.attr('data-title');

                $('#myModalLabel').text(title);
                $dataConfirmModal.find('.modal-body').text(message);
                $('#deleteForm').attr('action', href);
                $dataConfirmModal.modal({
                    show: true
                });
                return false;
            }
        };

        var render = function render() {
            $el.on('click', '.delete-asset', events['click']);
        };

        return {
            render: render
        };
    };

    /**
     * Application start point
     * Component definition stays out of load event, execution only happens.
     */
    $(function () {
        new Components.modals.confirmDelete().render();
    });
})(jQuery, window.snipeit.settings);

$(document).ready(function () {

    /*
    * Slideout help menu
    */
    $('.slideout-menu-toggle').on('click', function (event) {
        console.log('clicked');
        event.preventDefault();
        // create menu variables
        var slideoutMenu = $('.slideout-menu');
        var slideoutMenuWidth = $('.slideout-menu').width();

        // toggle open class
        slideoutMenu.toggleClass("open");

        // slide menu
        if (slideoutMenu.hasClass("open")) {
            slideoutMenu.show();
            slideoutMenu.animate({
                right: "0px"
            });
        } else {
            slideoutMenu.animate({
                right: -slideoutMenuWidth
            }, "-350px");
            slideoutMenu.fadeOut();
        }
    });

    /*
    * iCheck checkbox plugin
    */

    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });

    /*
    * Select2
    */

    var iOS = /iPhone|iPad|iPod/.test(navigator.userAgent) && !window.MSStream;
    if (!iOS) {
        // Vue collision: Avoid overriding a vue select2 instance
        // by checking to see if the item has already been select2'd.
        $('select.select2:not(".select2-hidden-accessible")').each(function (i, obj) {
            {
                $(obj).select2();
            }
        });
    }

    $('.datepicker').datepicker();

    // var datepicker = $.fn.datepicker.noConflict(); // return $.fn.datepicker to previously assigned value
    // $.fn.bootstrapDP = datepicker;
    // $('.datepicker').datepicker();


    // Crazy select2 rich dropdowns with images!
    $('.js-data-ajax').each(function (i, item) {
        var link = $(item);
        var endpoint = link.data("endpoint");
        var select = link.data("select");

        link.select2({

            /**
             * Adds an empty placeholder, allowing every select2 instance to be cleared.
             * This placeholder can be overridden with the "data-placeholder" attribute.
             */
            placeholder: '',
            allowClear: true,

            ajax: {

                // the baseUrl includes a trailing slash
                url: Ziggy.baseUrl + 'api/v1/' + endpoint + '/selectlist',
                dataType: 'json',
                delay: 250,
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data: function data(params) {
                    var data = {
                        search: params.term,
                        page: params.page || 1,
                        assetStatusType: link.data("asset-status-type")
                    };
                    return data;
                },
                processResults: function processResults(data, params) {

                    params.page = params.page || 1;

                    var answer = {
                        results: data.items,
                        pagination: {
                            more: "true" //(params.page  < data.page_count)
                        }
                    };

                    return answer;
                },
                cache: true
            },
            escapeMarkup: function escapeMarkup(markup) {
                return markup;
            }, // let our custom formatter work
            templateResult: formatDatalist,
            templateSelection: formatDataSelection
        });
    });

    function getSelect2Value(element) {

        // if the passed object is not a jquery object, assuming 'element' is a selector
        if (!(element instanceof jQuery)) element = $(element);

        var select = element.data("select2");

        // There's two different locations where the select2-generated input element can be. 
        searchElement = select.dropdown.$search || select.$container.find(".select2-search__field");

        var value = searchElement.val();
        return value;
    }

    $(".select2-hidden-accessible").on('select2:selecting', function (e) {
        var data = e.params.args.data;
        var isMouseUp = false;
        var element = $(this);
        var value = getSelect2Value(element);

        if (e.params.args.originalEvent) isMouseUp = e.params.args.originalEvent.type == "mouseup";

        // if selected item does not match typed text, do not allow it to pass - force close for ajax.
        if (!isMouseUp) {
            if (value.toLowerCase() && data.text.toLowerCase().indexOf(value) < 0) {
                e.preventDefault();

                element.select2('close');

                // if it does match, we set a flag in the event (which gets passed to subsequent events), telling it not to worry about the ajax
            } else if (value.toLowerCase() && data.text.toLowerCase().indexOf(value) > -1) {
                e.params.args.noForceAjax = true;
            }
        }
    });

    $(".select2-hidden-accessible").on('select2:closing', function (e) {
        var element = $(this);
        var value = getSelect2Value(element);
        var noForceAjax = false;
        var isMouseUp = false;
        if (e.params.args.originalSelect2Event) noForceAjax = e.params.args.originalSelect2Event.noForceAjax;
        if (e.params.args.originalEvent) isMouseUp = e.params.args.originalEvent.type == "mouseup";

        if (value && !noForceAjax && !isMouseUp) {
            var endpoint = element.data("endpoint");
            var assetStatusType = element.data("asset-status-type");
            $.ajax({
                url: Ziggy.baseUrl + 'api/v1/' + endpoint + '/selectlist?search=' + value + '&page=1' + (assetStatusType ? '&assetStatusType=' + assetStatusType : ''),
                dataType: 'json',
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                }
            }).done(function (response) {
                ;
                var currentlySelected = element.select2('data').map(function (x) {
                    return +x.id;
                }).filter(function (x) {
                    return x !== 0;
                });

                // makes sure we're not selecting the same thing twice for multiples
                var filteredResponse = response.items.filter(function (item) {
                    return currentlySelected.indexOf(+item.id) < 0;
                });

                var first = currentlySelected.length > 0 ? filteredResponse[0] : response.items[0];

                if (first && first.id) {
                    first.selected = true;

                    if ($("option[value='" + first.id + "']", element).length < 1) {
                        var option = new Option(first.text, first.id, true, true);
                        element.append(option);
                    } else {
                        var isMultiple = element.attr("multiple") == "multiple";
                        element.val(isMultiple ? element.val().concat(first.id) : element.val(first.id));
                    }
                    element.trigger('change');

                    element.trigger({
                        type: 'select2:select',
                        params: {
                            data: first
                        }
                    });
                }
            });
        }
    });

    function formatDatalist(datalist) {
        var loading_markup = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...';
        if (datalist.loading) {
            return loading_markup;
        }

        var markup = "<div class='clearfix'>";
        markup += "<div class='pull-left' style='padding-right: 10px;'>";
        if (datalist.image) {
            markup += "<div style='width: 30px;'><img src='" + datalist.image + "' style='max-height: 20px; max-width: 30px;'></div>";
        } else {
            markup += "<div style='height: 20px; width: 30px;'></div>";
        }

        markup += "</div><div>" + datalist.text + "</div>";
        markup += "</div>";
        return markup;
    }

    function formatDataSelection(datalist) {
        return datalist.text;
    }

    // This handles the radio button selectors for the checkout-to-foo options
    // on asset checkout and also on asset edit
    $(function () {
        $('input[name=checkout_to_type]').on("change", function () {
            var assignto_type = $('input[name=checkout_to_type]:checked').val();
            var userid = $('#assigned_user option:selected').val();

            if (assignto_type == 'asset') {
                $('#current_assets_box').fadeOut();
                $('#assigned_asset').show();
                $('#assigned_user').hide();
                $('#assigned_location').hide();
                $('.notification-callout').fadeOut();
            } else if (assignto_type == 'location') {
                $('#current_assets_box').fadeOut();
                $('#assigned_asset').hide();
                $('#assigned_user').hide();
                $('#assigned_location').show();
                $('.notification-callout').fadeOut();
            } else {

                $('#assigned_asset').hide();
                $('#assigned_user').show();
                $('#assigned_location').hide();
                if (userid) {
                    $('#current_assets_box').fadeIn();
                }
                $('.notification-callout').fadeIn();
            }
        });
    });

    // ------------------------------------------------
    // Deep linking for Bootstrap tabs
    // ------------------------------------------------
    var taburl = document.location.toString();

    // Allow full page URL to activate a tab's ID
    // ------------------------------------------------
    // This allows linking to a tab on page load via the address bar.
    // So a URL such as, http://snipe-it.local/hardware/2/#my_tab will
    // cause the tab on that page with an ID of “my_tab” to be active.
    if (taburl.match('#')) {
        $('.nav-tabs a[href="#' + taburl.split('#')[1] + '"]').tab('show');
    }

    // Allow internal page links to activate a tab's ID.
    // ------------------------------------------------
    // This allows you to link to a tab from anywhere on the page
    // including from within another tab. Also note that internal page
    // links either inside or out of the tabs need to include data-toggle="tab"
    // Ex: <a href="#my_tab" data-toggle="tab">Click me</a>
    $('a[data-toggle="tab"]').click(function (e) {
        var href = $(this).attr("href");
        history.pushState(null, null, href);
        e.preventDefault();
        $('a[href="' + $(this).attr('href') + '"]').tab('show');
    });

    // ------------------------------------------------
    // End Deep Linking for Bootstrap tabs
    // ------------------------------------------------


    // Image preview
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imagePreview').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function formatBytes(bytes) {
        if (bytes < 1024) return bytes + " Bytes";else if (bytes < 1048576) return (bytes / 1024).toFixed(2) + " KB";else if (bytes < 1073741824) return (bytes / 1048576).toFixed(2) + " MB";else return (bytes / 1073741824).toFixed(2) + " GB";
    };

    // File size validation
    $('#uploadFile').bind('change', function () {
        $('#upload-file-status').removeClass('text-success').removeClass('text-danger');
        $('.goodfile').remove();
        $('.badfile').remove();
        $('.badfile').remove();
        $('.previewSize').hide();
        $('#upload-file-info').html('');

        var max_size = $('#uploadFile').data('maxsize');
        var total_size = 0;

        for (var i = 0; i < this.files.length; i++) {
            total_size += this.files[i].size;
            $('#upload-file-info').append('<span class="label label-default">' + this.files[i].name + ' (' + formatBytes(this.files[i].size) + ')</span> ');
        }

        if (total_size > max_size) {
            $('#upload-file-status').addClass('text-danger').removeClass('help-block').prepend('<i class="badfile fa fa-times"></i> ').append('<span class="previewSize"> Upload is ' + formatBytes(total_size) + '.</span>');
        } else {
            $('#upload-file-status').addClass('text-success').removeClass('help-block').prepend('<i class="goodfile fa fa-check"></i> ');
            readURL(this);
            $('#imagePreview').fadeIn();
        }
    });
});

/***/ }),

/***/ "./resources/assets/js/snipeit_modals.js":
/***/ (function(module, exports) {

/* 
 * 
 * Snipe-IT Universal Modal support
 * 
 * Enables modal dialogs to create sub-resources throughout Snipe-IT
 * 
 */

/* 
HOW TO USE
 Create a Button looking like this:
 <a href='{{ route('modal.user') }}' data-toggle="modal"  data-target="#createModal" data-select='assigned_to' class="btn btn-sm btn-default">New</a>
 If you don't have access to Blade commands (like {{ and }}, etc), you can hard-code a URL as the 'href'
 data-toggle="modal" - required for Bootstrap Modals
data-target="#createModal" - fixed ID for the modal, do not change
data-select="assigned_to" - What is the *ID* of the select-dropdown that you're going to be adding to, if the modal-create was a success? Be on the lookout for duplicate ID's, it will confuse this library!
class="btn btn-sm btn-default" - makes it look button-ey, feel free to change :)

If you want to pass additional variables to the modal (In the Category Create one, for example, you can pass category_id), you can encode them as URL variables in the href

*/

$(function () {

    //handle modal-add-interstitial calls
    var model, select;

    if ($('#createModal').length == 0) {
        $('body').append('<div class="modal fade" id="createModal"></div><!-- /.modal -->');
    }

    $('#createModal').on("show.bs.modal", function (event) {
        var link = $(event.relatedTarget);
        model = link.data("dependency");
        select = link.data("select");
        $('#createModal').load(link.attr('href'), function () {
            //do we need to re-select2 this, after load? Probably.
            $('#createModal').find('select.select2').select2();
            // Initialize the ajaxy select2 with images.
            // This is a copy/paste of the code from snipeit.js, would be great to only have this in one place.
            $('.js-data-ajax').each(function (i, item) {
                var link = $(item);
                var endpoint = link.data("endpoint");
                var select = link.data("select");

                link.select2({
                    ajax: {

                        // the baseUrl includes a trailing slash
                        url: Ziggy.baseUrl + 'api/v1/' + endpoint + '/selectlist',
                        dataType: 'json',
                        delay: 250,
                        headers: {
                            "X-Requested-With": 'XMLHttpRequest',
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                        },
                        data: function data(params) {
                            var data = {
                                search: params.term,
                                page: params.page || 1,
                                assetStatusType: link.data("asset-status-type")
                            };
                            return data;
                        },
                        processResults: function processResults(data, params) {

                            params.page = params.page || 1;

                            var answer = {
                                results: data.items,
                                pagination: {
                                    more: "true" //(params.page  < data.page_count)
                                }
                            };

                            return answer;
                        },
                        cache: true
                    },
                    escapeMarkup: function escapeMarkup(markup) {
                        return markup;
                    }, // let our custom formatter work
                    templateResult: formatDatalist,
                    templateSelection: formatDataSelection
                });
            });
        });
    });

    $('#createModal').on('click', '#modal-save', function () {
        $.ajax({
            type: 'POST',
            url: $('.modal-body form').attr('action'),
            headers: {
                "X-Requested-With": 'XMLHttpRequest',
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
            },

            data: $('.modal-body form').serialize(),
            success: function success(result) {

                if (result.status == "error") {
                    var error_message = "";
                    for (var field in result.messages) {
                        error_message += "<li>Problem(s) with field <i><strong>" + field + "</strong></i>: " + result.messages[field];
                    }
                    $('#modal_error_msg').html(error_message).show();
                    return false;
                }
                var id = result.payload.id;
                var name = result.payload.name || result.payload.first_name + " " + result.payload.last_name;
                if (!id || !name) {
                    console.error("Could not find resulting name or ID from modal-create. Name: " + name + ", id: " + id);
                    return false;
                }
                $('#createModal').modal('hide');
                $('#createModal').html("");

                // "select" is the original drop-down menu that someone
                // clicked 'add' on to add a new 'thing'
                // this code adds the newly created object to that select
                var selector = document.getElementById(select);

                if (!selector) {
                    return false;
                }

                selector.options[selector.length] = new Option(name, id);
                selector.selectedIndex = selector.length - 1;
                $(selector).trigger("change");
                if (window.fetchCustomFields) {
                    fetchCustomFields();
                }
            },
            error: function error(result) {
                msg = result.responseJSON.messages || result.responseJSON.error;
                $('#modal_error_msg').html("Server Error: " + msg).show();
            }

        });
    });
});

function formatDatalist(datalist) {
    var loading_markup = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...';
    if (datalist.loading) {
        return loading_markup;
    }

    var markup = "<div class='clearfix'>";
    markup += "<div class='pull-left' style='padding-right: 10px;'>";
    if (datalist.image) {
        markup += "<div style='width: 30px;'><img src='" + datalist.image + "' style='max-height: 20px; max-width: 30px;'></div>";
    } else {
        markup += "<div style='height: 20px; width: 30px;'></div>";
    }

    markup += "</div><div>" + datalist.text + "</div>";
    markup += "</div>";
    return markup;
}

function formatDataSelection(datalist) {
    return datalist.text;
}

/***/ }),

/***/ 2:
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__("./resources/assets/js/snipeit.js");
module.exports = __webpack_require__("./resources/assets/js/snipeit_modals.js");


/***/ })

/******/ });