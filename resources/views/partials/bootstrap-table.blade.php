{{-- This Will load our default bootstrap-table settings on any table with a class of "snipe-table" and export it to the passed 'exportFile' name --}}
<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js?v=1') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js?v=1') }}"></script>
<script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>
<script>
$('.snipe-table').bootstrapTable({
        classes: 'table table-responsive table-no-bordered',
        undefinedText: '',
        iconsPrefix: 'fa',
        showRefresh: true,
        @if (isset($search))
        search: true,
        @endif
        pageSize: {{ $snipeSettings->per_page }},
        pagination: true,
        sidePagination: 'server',
        sortable: true,
        cookie: true,
        cookieExpire: '2y',
        @if (isset($columns))
        columns: {!! $columns !!},
        @endif
        mobileResponsive: true,
        @if (isset($multiSort))
        showMultiSort: true,
        @endif
        showExport: true,
        showColumns: true,
        trimOnSearch: false,
        exportDataType: 'all',
        exportTypes: ['csv', 'excel', 'txt','json', 'xml'],
        exportOptions: {
            fileName: '{{ $exportFile . "-" }}' + (new Date()).toISOString().slice(0,10),
            ignoreColumn: ['actions','change','checkbox']
        },
        maintainSelected: true,
        paginationFirstText: "{{ trans('general.first') }}",
        paginationLastText: "{{ trans('general.last') }}",
        paginationPreText: "{{ trans('general.previous') }}",
        paginationNextText: "{{ trans('general.next') }}",
        pageList: ['10','25','50','100','150','200','500','1000'],
        icons: {
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
        console.log($('.snipe-table').bootstrapTable('getSelections').length);
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
                return '<nobr><a href="{{ url('/') }}/' + destination + '/' + row.id + '/edit" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a> '
                    + '<a data-html="false" class="btn delete-asset btn-danger btn-sm" ' +
                    + 'data-toggle="modal" href="" data-content="Are you sure you wish to delete this?" '
                    + 'data-title="{{  trans('general.delete') }}?" onClick="return false;">'
                    + '<i class="fa fa-trash"></i></a></nobr>';
        };
    }

    function genericCheckinCheckoutFormatter(destination) {
        return function (value,row) {
            return '<nobr><a href="{{ url('/') }}/' + destination + '/' + row.id + '/edit" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a> '
                + '<a data-html="false" class="btn delete-asset btn-danger btn-sm" ' +
                + 'data-toggle="modal" href="" data-content="Are you sure you wish to delete this?" '
                + 'data-title="{{  trans('general.delete') }}?" onClick="return false;">'
                + '<i class="fa fa-trash"></i></a></nobr>';
        };
    }



    var formatters = [
        'hardware',
        'accessories',
        'locations',
        'users',
        'manufacturers',
        'statuslabels',
        'models',
        'licenses',
        'categories',
        'suppliers',
        'companies',
        'depreciations',
        'fieldsets'
    ];

    for (var i in formatters) {
        window[formatters[i] + 'LinkFormatter'] = genericRowLinkFormatter(formatters[i]);
        window[formatters[i] + 'LinkObjFormatter'] = genericColumnObjLinkFormatter(formatters[i]);
        window[formatters[i] + 'ActionsFormatter'] = genericActionsFormatter(formatters[i]);
    }



    function createdAtFormatter(value, row) {
        if ((value) && (value.date)) {
            return value.date;
        }
    }

    function trueFalseFormatter(value, row) {
        if ((value) && ((value == 'true') || (value == '1'))) {
            return '<i class="fa fa-check"></i>';
        } else {
            return '<i class="fa fa-times"></i>';
        }
    }


    function emailFormatter(value, row) {
        if (value) {
            return '<a href="mailto:' + value + '"> ' + value + '</a>';
        }
    }

    function imageFormatter(value, row) {
        console.log(value);
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
