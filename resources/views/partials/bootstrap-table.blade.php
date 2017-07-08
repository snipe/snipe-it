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
@endif

<script>
$('.snipe-table').bootstrapTable({
        classes: 'table table-responsive table-no-bordered',
        undefinedText: '',
        iconsPrefix: 'fa',

        @if (isset($search))
            search: true,
        @endif


        paginationVAlign: 'both',
        sidePagination: 'server',
        sortable: true,


       @if (!isset($simple_view))

        showRefresh: true,
        pagination: true,
        pageSize: {{ $snipeSettings->per_page }},

        cookie: true,
        cookieExpire: '2y',
        showExport: true,
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
        pageList: ['50','100','150','200','500','1000'],
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
        },

    });

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
            if ((value) && (value.name)) {
                return '<a href="{{ url('/') }}/' + destination + '/' + value.id + '"> ' + value.name + '</a>';
            }
        };
    }

    // Make the edit/delete buttons
    function genericActionsFormatter(destination) {
        return function (value,row) {

            var actions = '<nobr>';

            if ((row.available_actions) && (row.available_actions.clone === true)) {
                actions += '<a href="{{ url('/') }}/' + destination + '/' + row.id + '/clone" class="btn btn-sm btn-info"><i class="fa fa-copy"></i></a>&nbsp;';
            }

            if ((row.available_actions) && (row.available_actions.update === true)) {
                actions += '<a href="{{ url('/') }}/' + destination + '/' + row.id + '/edit" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a>&nbsp;';
            }

            if ((row.available_actions) && (row.available_actions.delete === true)) {
                actions += '<a href="{{ url('/') }}/' + destination + '/' + row.id + '" '
                    + ' class="btn btn-danger btn-sm delete-asset" '
                    + ' data-toggle="modal" '
                    + ' data-content="{{ trans('general.sure_to_delete') }} ' + row.name + '?" '
                    + ' data-title="{{  trans('general.delete') }}?" onClick="return false;">'
                    + '<i class="fa fa-trash"></i></a></nobr>';
            }
            return actions;

        };
    }


    // This handles
    function polymorphicItemFormatter(value) {

        var item_destination = '';

        if ((value) && (value.type)) {

            if (value.type == 'asset') {
                item_destination = 'hardware';
            } else if (value.type == 'accessory') {
                item_destination = 'accessories';
            } else if (value.type == 'component') {
                item_destination = 'components';
            } else if (value.type == 'consumable') {
                item_destination = 'consumables';
            } else if (value.type == 'license') {
                item_destination = 'licenses';
            } else if (value.type == 'user') {
                item_destination = 'users';
            }

            return '<a href="{{ url('/') }}/' + item_destination +'/' + value.id + '"> ' + value.name + '</a>';

        } else {
            return '';
        }


    }


    function genericCheckinCheckoutFormatter(destination) {
        return function (value,row) {

            // The user is allowed to check items out, AND the item is deployable
            if ((row.available_actions.checkout == true) && (row.user_can_checkout == true) && (!row.assigned_to)) {
                return '<a href="{{ url('/') }}/' + destination + '/' + row.id + '/checkout" class="btn btn-sm btn-primary">{{ trans('general.checkout') }}</a>';

            // The user is allowed to check items out, but the item is not deployable
            } else if (((row.user_can_checkout == false)) && (row.available_actions.checkout == true) && (!row.assigned_to)) {
                return '<a class="btn btn-sm btn-primary disabled">{{ trans('general.checkout') }}</a>';

            // The user is allowed to check items in
            } else if ((row.available_actions.checkin == true)  && (row.assigned_to)) {
                return '<nobr><a href="{{ url('/') }}/' + destination + '/' + row.id + '/checkin" class="btn btn-sm btn-primary">{{ trans('general.checkin') }}</a>';

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



    function createdAtFormatter(value, row) {
        if ((value) && (value.date)) {
            return value.date;
        }
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

    function orderNumberObjFilterFormatter(value, row) {
        if (value) {
            return '<a href="{{ url('/') }}/hardware/?order_number=' + row.order_number + '"> ' + row.order_number + '</a>';
        }
    }


   function imageFormatter(value, row) {
        if (value) {
            return '<img src="' + value + '" height="50" width="50">';
        }
    }

    $(function () {
        $('#bulkEdit').click(function () {
            var selectedIds = $('.snipe-table').bootstrapTable('getSelections');
            $.each(selectedIds, function(key,value) {
                $( "#bulkForm" ).append($('<input type="hidden" name="ids[' + value.id + ']" value="' + value.id + '">' ));
            });

        });
    });


</script>
