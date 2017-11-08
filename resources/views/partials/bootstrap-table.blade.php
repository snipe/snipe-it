{{-- This Will load our default bootstrap-table settings on any table with a class of "snipe-table" and export it to the passed 'exportFile' name --}}
<script src="{{ asset('js/bootstrap-table.js') }}"></script>
<script src="{{ asset('js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>

@if (!isset($simple_view))
<script src="{{ asset('js/extensions/export/bootstrap-table-export.js?v=1') }}"></script>
<script src="{{ asset('js/extensions/cookie/bootstrap-table-cookie.js?v=1') }}"></script>
<script src="{{ asset('js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('js/FileSaver.min.js') }}"></script>
<script src="{{ asset('js/jspdf.min.js') }}"></script>
<script src="{{ asset('js/jspdf.plugin.autotable.js') }}"></script>
<script src="{{ asset('js/extensions/export/jquery.base64.js') }}"></script>
<script src="{{ asset('js/extensions/toolbar/bootstrap-table-toolbar.js') }}"></script>
<script src="{{ asset('js/extensions/sticky-header/bootstrap-table-sticky-header.js') }}"></script>
@endif

<script nonce="{{ csrf_token() }}">

    var $table = $('.snipe-table');
    $(function () {
        buildTable($table, 20, 50);
    });
    function buildTable($el) {
        var stickyHeaderOffsetY = 0;

        if ( $('.navbar-fixed-top').css('height') ) {
            stickyHeaderOffsetY = +$('.navbar-fixed-top').css('height').replace('px','');
        }
        if ( $('.navbar-fixed-top').css('margin-bottom') ) {
            stickyHeaderOffsetY += +$('.navbar-fixed-top').css('margin-bottom').replace('px','');
        }



        $('.snipe-table').bootstrapTable('destroy').bootstrapTable({
        classes: 'table table-responsive table-no-bordered',
        undefinedText: '',
        iconsPrefix: 'fa',

        @if (isset($search))
            search: true,
        @endif


        paginationVAlign: 'both',
        sidePagination: '{{ (isset($clientSearch)) ? 'client' : 'server' }}',
        sortable: true,

       @if (!isset($simple_view))

        showRefresh: true,
        pagination: true,
        pageSize: 20,
        cookie: true,
        cookieExpire: '2y',
        showExport: true,
        stickyHeader: true,
        stickyHeaderOffsetY: stickyHeaderOffsetY + 'px',


        @if (isset($showFooter))
        showFooter: true,
        @endif
        showColumns: true,
        trimOnSearch: false,

        @if (isset($multiSort))
        showMultiSort: true,
        @endif

            @if (isset($exportFile))
            exportDataType: 'all',
            exportTypes: ['csv', 'excel', 'doc', 'txt','json', 'xml', 'pdf'],
            exportOptions: {

                fileName: '{{ $exportFile . "-" }}' + (new Date()).toISOString().slice(0,10),
                ignoreColumn: ['actions','change','checkbox','checkincheckout','icon'],
                worksheetName: "Snipe-IT Export",
                jspdf: {
                    orientation: 'l',
                    autotable: {
                        styles: {
                            rowHeight: 20,
                            fontSize: 10,
                            overflow: 'linebreak',
                        },
                        headerStyles: {fillColor: 255, textColor: 0},
                        //alternateRowStyles: {fillColor: [60, 69, 79], textColor: 255}
                    }
                }
            },
            @endif

        @endif

        @if (isset($columns))
         columns: {!! $columns !!},
        @endif

        mobileResponsive: true,
        maintainSelected: true,
        paginationFirstText: "{{ trans('general.first') }}",
        paginationLastText: "{{ trans('general.last') }}",
        paginationPreText: "{{ trans('general.previous') }}",
        paginationNextText: "{{ trans('general.next') }}",
        formatLoadingMessage: function () {
            return '<h4><i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading... please wait.... </h4>';
        },
        pageList: ['20', '30','50','100','150','200'],
        icons: {
            advancedSearchIcon: 'fa fa-search-plus',
            paginationSwitchDown: 'fa-caret-square-o-down',
            paginationSwitchUp: 'fa-caret-square-o-up',
            columns: 'fa-columns',
            @if( isset($multiSort))
            sort: 'fa fa-sort-amount-desc',
            plus: 'fa fa-plus',
            minus: 'fa fa-minus',
            @endif
            refresh: 'fa-refresh'
        }

    });
    }



    function dateRowCheckStyle(value) {
        if ((value.days_to_next_audit) && (value.days_to_next_audit < {{ $snipeSettings->audit_warning_days ?: 0 }})) {
            return { classes : "danger" }
        }
        return {};
    }


    // Handle whether or not the edit button should be disabled
    $('.snipe-table').on('check.bs.table', function () {
        $('#bulkEdit').removeAttr('disabled');
    });

    $('.snipe-table').on('check-all.bs.table', function () {
        $('#bulkEdit').removeAttr('disabled');
    });

    $('.snipe-table').on('uncheck.bs.table', function () {
        if ($('.snipe-table').bootstrapTable('getSelections').length == 0) {
            $('#bulkEdit').attr('disabled', 'disabled');
        }
    });

    $('.snipe-table').on('uncheck-all.bs.table', function (e, row) {
        $('#bulkEdit').attr('disabled', 'disabled');
    });


    // This only works for model index pages because it uses the row's model ID
    function genericRowLinkFormatter(destination) {
        return function (value,row) {
            if (value) {
                return '<a href="{{ url('/') }}/' + destination + '/' + row.id + '"> ' + value + '</a>';
            }
        };
    }

    // Use this when we're introspecting into a column object and need to link
    function genericColumnObjLinkFormatter(destination) {
        return function (value,row) {
            if ((value) && (value.status_meta)) {

                var text_color;
                var icon_style;

                switch (value.status_meta) {
                    case 'deployed':
                        text_color = 'blue';
                        icon_style = 'fa-circle';
                    break;
                    case 'deployable':
                        text_color = 'green';
                        icon_style = 'fa-circle';
                    break;
                    case 'pending':
                        text_color = 'orange';
                        icon_style = 'fa-circle';
                        break;
                    default:
                        text_color = 'red';
                        icon_style = 'fa-times';
                }

                return '<nobr><a href="{{ url('/') }}/' + destination + '/' + value.id + '" data-tooltip="true" title="'+ value.status_meta + '"> <i class="fa ' + icon_style + ' text-' + text_color + '"></i> ' + value.name + '</a></nobr>';
            } else if ((value) && (value.name)) {
                return '<nobr><a href="{{ url('/') }}/' + destination + '/' + value.id + '"> ' + value.name + '</a></span>';
            }
        };
    }

    // Make the edit/delete buttons
    function genericActionsFormatter(destination) {
        return function (value,row) {

            var actions = '<nobr>';

            var dest = destination;
            if (destination=='groups') {
                var dest = 'admin/groups';
            }

            if ((row.available_actions) && (row.available_actions.clone === true)) {
                actions += '<a href="{{ url('/') }}/' + dest + '/' + row.id + '/clone" class="btn btn-sm btn-info" data-tooltip="true" title="Clone"><i class="fa fa-copy"></i></a>&nbsp;';
            }

            if ((row.available_actions) && (row.available_actions.update === true)) {
                actions += '<a href="{{ url('/') }}/' + dest + '/' + row.id + '/edit" class="btn btn-sm btn-warning" data-tooltip="true" title="Update"><i class="fa fa-pencil"></i></a>&nbsp;';
            }

            if ((row.available_actions) && (row.available_actions.delete === true)) {
                actions += '<a href="{{ url('/') }}/' + dest + '/' + row.id + '" '
                    + ' class="btn btn-danger btn-sm delete-asset"  data-tooltip="true"  '
                    + ' data-toggle="modal" '
                    + ' data-content="{{ trans('general.sure_to_delete') }} ' + row.name + '?" '
                    + ' data-title="{{  trans('general.delete') }}" onClick="return false;">'
                    + '<i class="fa fa-trash"></i></a>&nbsp;';
            } else {
                actions += '<a class="btn btn-danger btn-sm delete-asset disabled" onClick="return false;"><i class="fa fa-trash"></i></a>&nbsp;';
            }

            if ((row.available_actions) && (row.available_actions.restore === true)) {
                actions += '<a href="{{ url('/') }}/' + dest + '/' + row.id + '/restore" class="btn btn-sm btn-warning" data-tooltip="true" title="Restore"><i class="fa fa-retweet"></i></a>&nbsp;';
            }

            actions +='</nobr>';
            return actions;

        };
    }


    // This handles the icons and display of polymorphic entries
    function polymorphicItemFormatter(value) {

        var item_destination = '';
        var item_icon;

        if ((value) && (value.type)) {

            if (value.type == 'asset') {
                item_destination = 'hardware';
                item_icon = 'fa-barcode';
            } else if (value.type == 'accessory') {
                item_destination = 'accessories';
                item_icon = 'fa-keyboard-o';
            } else if (value.type == 'component') {
                item_destination = 'components';
                item_icon = 'fa-hdd-o';
            } else if (value.type == 'consumable') {
                item_destination = 'consumables';
                item_icon = 'fa-tint';
            } else if (value.type == 'license') {
                item_destination = 'licenses';
                item_icon = 'fa-floppy-o';
            } else if (value.type == 'user') {
                item_destination = 'users';
                item_icon = 'fa-user';
            } else if (value.type == 'location') {
                item_destination = 'locations'
                item_icon = 'fa-map-marker';
            }

            return '<nobr><a href="{{ url('/') }}/' + item_destination +'/' + value.id + '" data-tooltip="true" title="' + value.type + '"><i class="fa ' + item_icon + ' text-blue"></i> ' + value.name + '</a></nobr>';

        } else {
            return '';
        }


    }


    function genericCheckinCheckoutFormatter(destination) {
        return function (value,row) {

            // The user is allowed to check items out, AND the item is deployable
            if ((row.available_actions.checkout == true) && (row.user_can_checkout == true) && (!row.assigned_to)) {
                // case for licenses
                if (row.next_seat) {
                    return '<a href="{{ url('/') }}/' + destination + '/' + row.next_seat + '/checkout" class="btn btn-sm bg-maroon" data-tooltip="true" title="Check this item out to a user">{{ trans('general.checkout') }}</a>';
                } else {
                    return '<a href="{{ url('/') }}/' + destination + '/' + row.id + '/checkout" class="btn btn-sm bg-maroon" data-tooltip="true" title="Check this item out to a user">{{ trans('general.checkout') }}</a>';
                }


            // The user is allowed to check items out, but the item is not deployable
            } else if (((row.user_can_checkout == false)) && (row.available_actions.checkout == true) && (!row.assigned_to)) {
                return '<div  data-tooltip="true" title="This item has a status label that is undeployable and cannot be checked out at this time."><a class="btn btn-sm bg-maroon disabled">{{ trans('general.checkout') }}</a></div>';

            // The user is allowed to check items in
            } else if (row.available_actions.checkin == true)  {
                if (row.assigned_to) {
                    return '<nobr><a href="{{ url('/') }}/' + destination + '/' + row.id + '/checkin" class="btn btn-sm bg-purple" data-tooltip="true" title="Check this item in so it is available for re-imaging, re-issue, etc.">{{ trans('general.checkin') }}</a>';
                } else if (row.assigned_pivot_id) {
                    return '<nobr><a href="{{ url('/') }}/' + destination + '/' + row.assigned_pivot_id + '/checkin" class="btn btn-sm bg-purple" data-tooltip="true" title="Check this item in so it is available for re-imaging, re-issue, etc.">{{ trans('general.checkin') }}</a>';
                }

            } 

        }


    }



    var formatters = [
        'hardware',
        'accessories',
        'consumables',
        'components',
        'locations',
        'users',
        'manufacturers',
        'statuslabels',
        'models',
        'licenses',
        'categories',
        'suppliers',
        'departments',
        'companies',
        'depreciations',
        'fieldsets',
        'groups'
    ];

    for (var i in formatters) {
        window[formatters[i] + 'LinkFormatter'] = genericRowLinkFormatter(formatters[i]);
        window[formatters[i] + 'LinkObjFormatter'] = genericColumnObjLinkFormatter(formatters[i]);
        window[formatters[i] + 'ActionsFormatter'] = genericActionsFormatter(formatters[i]);
        window[formatters[i] + 'InOutFormatter'] = genericCheckinCheckoutFormatter(formatters[i]);
    }


    // This is  gross, but necessary so that we can package the API response
    // for custom fields in a more useful way.
    function customFieldsFormatter(value, row) {


            if ((!this) || (!this.title)) {
                return '';
            }

            var field_column = this.title;

            // Pull out any HTMl that might be passed via the presenter
            // (for example, the locked icon for encrypted fields)
            var field_column_plain = field_column.replace(/<(?:.|\n)*?> ?/gm, '');
            if ((row.custom_fields) && (row.custom_fields[field_column_plain])) {
                return row.custom_fields[field_column_plain].value;
            }

    }


    function createdAtFormatter(value) {
        if ((value) && (value.date)) {
            return value.date;
        }
    }

    function groupsFormatter(value) {

        if (value) {
            var groups = '';
            for (var index in value.rows) {
                groups += '<a href="{{ url('/') }}/admin/groups/' + value.rows[index].id + '" class="label label-default"> ' + value.rows[index].name + '</a> ';
            }
            return groups;
        }
    }

    function deployedLocationFormatter(row, value) {
        if ((row) && (row!=undefined)) {
            return '<a href="{{ url('/') }}/locations/' + row.id + '"> ' + row.name + '</a>';
        } else if (value.rtd_location) {
            return '<a href="{{ url('/') }}/locations/' + value.rtd_location.id + '" data-tooltip="true" title="Default Location"> ' + value.rtd_location.name + '</a>';
        }

    }

    function groupsAdminLinkFormatter(value, row) {
        return '<a href="{{ url('/') }}/admin/groups/' + row.id + '"> ' + value + '</a>';
    }

    function trueFalseFormatter(value, row) {
        if ((value) && ((value == 'true') || (value == '1'))) {
            return '<i class="fa fa-check text-success"></i>';
        } else {
            return '<i class="fa fa-times text-danger"></i>';
        }
    }

    function dateDisplayFormatter(value, row) {
        if (value) {
            return  value.formatted;
        }
    }

    function iconFormatter(value, row) {
        if (value) {
            return '<i class="' + value + '"></i>';
        }
    }

    function emailFormatter(value, row) {
        if (value) {
            return '<a href="mailto:' + value + '"> ' + value + '</a>';
        }
    }

    function linkFormatter(value, row) {
        if (value) {
            return '<a href="' + value + '"> ' + value + '</a>';
        }
    }

    function assetCompanyFilterFormatter(value, row) {
        if (value) {
            return '<a href="{{ url('/') }}/hardware/?company_id=' + row.id + '"> ' + value + '</a>';
        }
    }

    function assetCompanyObjFilterFormatter(value, row) {
        if (row.company) {
            return '<a href="{{ url('/') }}/hardware/?company_id=' + row.company.id + '"> ' + row.company.name + '</a>';
        }
    }

    function usersCompanyObjFilterFormatter(value, row) {
        if (value) {
            return '<a href="{{ url('/') }}/users/?company_id=' + row.id + '"> ' + value + '</a>';
        } else {
            return value;
        }
    }

    function employeeNumFormatter(value, row) {

        if ((row.assigned_to) && ((row.assigned_to.employee_number))) {
            return '<a href="{{ url('/') }}/users/' + row.assigned_to.id + '"> ' + row.assigned_to.employee_number + '</a>';
        }
    }

    function orderNumberObjFilterFormatter(value, row) {
        if (value) {
            return '<a href="{{ url('/') }}/hardware/?order_number=' + row.order_number + '"> ' + row.order_number + '</a>';
        }
    }


   function imageFormatter(value, row) {
        if (value) {
            return '<a href="' + value + '" data-toggle="lightbox" data-type="image"><img src="' + value + '" style="max-height: {{ $snipeSettings->thumbnail_max_h }}px; width: auto;" class="img-responsive"></a>';
        }
    }

    function sumFormatter(data) {
        var field = this.field;
        var total_sum = data.reduce(function(sum, row) {
            return (sum) + (parseFloat(row[field]) || 0);
        }, 0);
        return total_sum.toFixed(2);
    }
    

    $(function () {
        $('#bulkEdit').click(function () {
            var selectedIds = $('.snipe-table').bootstrapTable('getSelections');
            $.each(selectedIds, function(key,value) {
                $( "#bulkForm" ).append($('<input type="hidden" name="ids[' + value.id + ']" value="' + value.id + '">' ));
            });

        });
    });


    // This is necessary to make the bootstrap tooltips work inside of the
    // wenzhixin/bootstrap-table formatters
    $(function() {
        $('#table').on('post-body.bs.table', function () {
            $('[data-tooltip="true"]').tooltip({
                container: 'body'
            });
        });
    });




</script>
