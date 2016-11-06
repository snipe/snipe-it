@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.components') }}
@parent
@stop

@section('header_right')
    @can('components.create')
        <a href="{{ route('create/component') }}" class="btn btn-primary pull-right"> {{ trans('general.create') }}</a>
    @endcan
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">

    <div class="box box-default">
        <div class="box-body">
          {{ Form::open([
               'method' => 'POST',
               'route' => ['component/bulk-form'],
               'class' => 'form-inline' ]) }}


          <div id="toolbar">
            <!-- <select name="bulk_actions" class="form-control select2" style="width: 130px;">
              <option value="checkout">Checkout</option>
              <option value="checkin">Checkin</option>
            </select>
            <button class="btn btn-default" id="bulkEdit" disabled>Go</button>
            -->
          </div>


          <table
          data-toolbar="#toolbar"
          name="components"
          class="table table-striped"
          id="table"
          data-url="{{route('api.components.list') }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="componentsTable-{{ config('version.hash_version') }}-{{ config('version.hash_version') }}">
            <thead>
              <tr>
                <th data-class="hidden-xs" data-switchable="false" data-searchable="false" data-sortable="false" data-field="checkbox"><div class="text-center"><input type="checkbox" id="checkAll" style="padding-left: 0px;"></div></th>
                <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                <th data-switchable="true" data-visible="false" data-searchable="true" data-sortable="true" data-field="companyName">{{ trans('admin/companies/table.title') }}</th>
                <th data-sortable="true" data-searchable="true" data-field="name">{{ trans('admin/components/table.title') }}</th>
                <th data-sortable="true" data-searchable="true" data-field="serial_number" data-visible="false">{{ trans('admin/hardware/form.serial') }}</th>
                <th data-searchable="true" data-sortable="true" data-field="location">{{ trans('general.location') }}</th>
                <th data-searchable="true" data-sortable="true" data-field="category">{{ trans('general.category') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="total_qty"> {{ trans('admin/components/general.total') }}</th>
                <th data-switchable="true" data-searchable="false" data-sortable="true" data-field="min_amt"> {{ trans('general.min_amt') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="numRemaining"> {{ trans('admin/components/general.remaining') }}</th>
                <th data-sortable="true" data-searchable="true" data-field="order_number" data-visible="false">{{ trans('admin/components/general.order') }}</th>
                <th data-sortable="true" data-searchable="true" data-field="purchase_date" data-visible="false">{{ trans('admin/components/general.date') }}</th>
                <th data-sortable="true" data-searchable="true" data-field="purchase_cost" data-visible="false">{{ trans('admin/components/general.cost') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions"> {{ trans('table.actions') }}</th>

              </tr>
            </thead>
          </table>
          {{ Form::close() }}
        </div><!-- /.box-body -->
      </div><!-- /.box -->

  </div>
</div>


@section('moar_scripts')
<script src="{{ asset('assets/js/bootstrap-table.js') }}"></script>
<script src="{{ asset('assets/js/extensions/cookie/bootstrap-table-cookie.js') }}"></script>
<script src="{{ asset('assets/js/extensions/mobile/bootstrap-table-mobile.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/bootstrap-table-export.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/tableExport.js') }}"></script>
<script src="{{ asset('assets/js/extensions/export/jquery.base64.js') }}"></script>
<script type="text/javascript">
    $('#table').bootstrapTable({
        classes: 'table table-responsive table-no-bordered',
        undefinedText: '',
        iconsPrefix: 'fa',
        showRefresh: true,
        search: true,
        pageSize: {{ $snipeSettings->per_page }},
        pagination: true,
        sidePagination: 'server',
        sortable: true,
        cookie: true,
        cookieExpire: '2y',
        mobileResponsive: true,
        showExport: true,
        showColumns: true,
        exportDataType: 'all',
        exportTypes: ['csv', 'txt','json', 'xml'],
        exportOptions: {
            fileName: 'components-export-' + (new Date()).toISOString().slice(0,10),
        },
        maintainSelected: true,
        paginationFirstText: "{{ trans('general.first') }}",
        paginationLastText: "{{ trans('general.last') }}",
        paginationPreText: "{{ trans('general.previous') }}",
        paginationNextText: "{{ trans('general.next') }}",
        pageList: ['10','25','50','100','150','200'],
        icons: {
            paginationSwitchDown: 'fa-caret-square-o-down',
            paginationSwitchUp: 'fa-caret-square-o-up',
            columns: 'fa-columns',
            refresh: 'fa-refresh'
        },

    });
</script>

<script>
    $(function() {
        function checkForChecked() {
            var check_checked = $('input.one_required:checked').length;
            if (check_checked > 0) {
                $('#bulkEdit').removeAttr('disabled');
            }
            else {
                $('#bulkEdit').attr('disabled', 'disabled');
            }
        }
        $('#table').on('change','input.one_required',checkForChecked);
        $("#checkAll").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
            checkForChecked();
        });
    });
</script>

@stop

@stop
