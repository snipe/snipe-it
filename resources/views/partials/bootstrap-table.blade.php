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

    function userFormatter(value, row) {
        if (value.name) {
            return '<a href="{{ url('/') }}/users/' + value.id + '"> ' + value.name + '</a>';
        } else if (value) {
            return '<a href="{{ url('/') }}/users/' + row.id + '"> ' + value + '</a>';
        }
    }

    function assetFormatter(value, row) {
        if (value) {
            return '<a href="{{ url('/') }}/hardware/' + row.id + '"> ' + value + '</a>';
        }
    }

    function manufacturerFormatter(value, row) {
        if (value) {
            return '<a href="{{ url('/') }}/manufacturers/' + row.id + '"> ' + value.name + '</a>';
        }
    }

    function statusFormatter(value, row) {
        if (value) {
            return '<a href="{{ url('/') }}/statuslabels/' + value.id + '"> ' + value.name + '</a>';
        }
    }

    function modelFormatter(value, row) {
        if (value) {
            return '<a href="{{ url('/') }}/models/' + value.id + '"> ' + value.name + '</a>';
        }
    }

    function licenseFormatter(value, row) {
        if (value) {
            return '<a href="{{ url('/') }}/licenses/' + row.id + '"> ' + row.name + '</a>';
        }
    }

    function categoryFormatter(value, row) {
        if (value) {
            return '<a href="{{ url('/') }}/categories/' + value.id + '"> ' + value.name + '</a>';
        }
    }

    function companyFormatter(value, row) {
        if ((value) && (value[0].name)) {
            return '<a href="{{ url('/') }}/companies/' + value[0].id + '"> ' + value[0].name + '</a>';
        }
    }

    function locationFormatter(value, row) {
        if ((value) && (value[0].name)) {
            return '<a href="{{ url('/') }}/locations/' + value[0].id + '"> ' + value[0].name + '</a>';
        }
    }

    function emailFormatter(value, row) {
        if (value) {
            return '<a href="mailto:' + value + '"> ' + value + '</a>';
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
