
/**
 * Module containing core application logic.
 * @param  {jQuery} $        Insulated jQuery object
 * @param  {JSON} settings Insulated `window.snipeit.settings` object.
 * @return {IIFE}          Immediately invoked. Returns self.
 */

var lineOptions = {

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

var pieOptions = {
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
    legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li>" +
    "<i class='fa fa-circle-o' style='color: <%=segments[i].fillColor%>'></i>" +
    "<%if(segments[i].label){%><%=segments[i].label%><%}%> foo</li><%}%></ul>",
    //String - A tooltip template
    tooltipTemplate: "<%=value %> <%=label%> "
};

//-----------------
//- END PIE CHART -
//-----------------



(function($, settings) {
    var Components = {};
    Components.modals = {};

    // confirm delete modal
    Components.modals.confirmDelete = function() {
        var $el = $('table');

        var events = {
            'click': function(evnt) {
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

        var render = function() {
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
    $(function() {
        new Components.modals.confirmDelete().render();
    });
}(jQuery, window.snipeit.settings));





$(document).ready(function () {

    /*
    * Slideout help menu
    */
     $('.slideout-menu-toggle').on('click', function(event){
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

     var iOS = /iPhone|iPad|iPod/.test(navigator.userAgent)  && !window.MSStream;
     if(!iOS)
     {
        // Vue collision: Avoid overriding a vue select2 instance
        // by checking to see if the item has already been select2'd.
        $('select.select2:not(".select2-hidden-accessible")').each(function (i,obj) {
            {
                $(obj).select2();
            }
        });
     }
     $('.datepicker').datepicker();

    var datepicker = $.fn.datepicker.noConflict(); // return $.fn.datepicker to previously assigned value
    $.fn.bootstrapDP = datepicker;
    $('.datepicker').datepicker();


    // Crazy select2 rich dropdowns with images!
    $('.js-data-ajax').each( function (i,item) {
        var link = $(item);
        var endpoint = link.data("endpoint");
        var select = link.data("select");

        link.select2({

            ajax: {

                // the baseUrl includes a trailing slash
                url: baseUrl + 'api/v1/' + endpoint + '/selectlist',
                dataType: 'json',
                delay: 250,
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data: function (params) {
                    var data = {
                        search: params.term,
                        page: params.page || 1,
                        assetStatusType: link.data("asset-status-type"),
                    };
                    return data;
                },
                processResults: function (data, params) {

                    params.page = params.page || 1;

                    var answer =  {
                        results: data.items,
                        pagination: {
                            more: "true" //(params.page  < data.page_count)
                        }
                    };

                    return answer;
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            templateResult: formatDatalist,
            templateSelection: formatDataSelection
        });

    });

    function formatDatalist (datalist) {
        var loading_markup = '<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...';
        if (datalist.loading) {
            return loading_markup;
        }

        var markup = "<div class='clearfix'>" ;
        markup +="<div class='pull-left' style='padding-right: 10px;'>";
        if (datalist.image) {
            markup += "<div style='width: 30px;'><img src='" + datalist.image + "' style='max-height: 20px; max-width: 30px;'></div>";
        } else {
            markup += "<div style='height: 20px; width: 30px;'></div>";
        }

        markup += "</div><div>" + datalist.text + "</div>";
        markup += "</div>";
        return markup;
    }

    function formatDataSelection (datalist) {
        return datalist.text;
    }

    // This handles the radio button selectors for the checkout-to-foo options
    // on asset checkout and also on asset edit
    $(function() {
        $('input[name=checkout_to_type]').on("change",function () {
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
            } else  {

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
    if (taburl.match('#') ) {
        $('.nav-tabs a[href="#'+taburl.split('#')[1]+'"]').tab('show');
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
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function formatBytes(bytes) {
        if(bytes < 1024) return bytes + " Bytes";
        else if(bytes < 1048576) return(bytes / 1024).toFixed(3) + " KB";
        else if(bytes < 1073741824) return(bytes / 1048576).toFixed(3) + " MB";
        else return(bytes / 1073741824).toFixed(3) + " GB";
    };

     // File size validation
    $('#uploadFile').bind('change', function() {
        $('#upload-file-status').removeClass('text-success').removeClass('text-danger');
        $('.goodfile').remove();
        $('.badfile').remove();
        $('.badfile').remove();
        $('.previewSize').hide();

        var max_size = $('#uploadFile').data('maxsize');
        var actual_size = this.files[0].size;

        if (actual_size > max_size) {
            $('#upload-file-status').addClass('text-danger').removeClass('help-block').prepend('<i class="badfile fa fa-times"></i> ').append('<span class="previewSize">This file is ' + formatBytes(actual_size) + '.</span>');
        } else {
            $('#upload-file-status').addClass('text-success').removeClass('help-block').prepend('<i class="goodfile fa fa-check"></i> ');
            readURL(this);
            $('#imagePreview').fadeIn();
        }
        $('#upload-file-info').html(this.files[0].name);

    });










});
