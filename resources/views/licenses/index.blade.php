@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/licenses/general.software_licenses') }}
@parent
@stop


@section('header_right')
@can('licenses.create')
    <a href="{{ route('create/licenses') }}" class="btn btn-primary pull-right">
      {{ trans('general.create') }}
    </a>
    @endcan
@stop

{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-12">
    <div class="box">

    <div class="box-body">
      <table
      name="licenses"
      id="table"
      data-url="{{route('api.licenses.list') }}"
      class="table table-striped"
      data-cookie="true"
      data-click-to-select="true"
      data-cookie-id-table="licenseTable">
          <thead>
              <tr>
                  <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                  <th data-field="company" data-sortable="true" data-switchable="true">{{ trans('general.company') }}</th>
                  <th data-field="name" data-sortable="true">{{ trans('admin/licenses/table.title') }}</th>
                  <th data-field="manufacturer" data-sortable="true">{{ trans('general.manufacturer') }}</th>
                  <th data-field="serial" data-sortable="true" >{{ trans('admin/licenses/table.serial') }}</th>
                  <th data-field="license_name" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.to_name') }}</th>
                  <th data-field="license_email" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.to_email') }}</th>
                  <th data-field="totalSeats" data-sortable="false">{{ trans('admin/licenses/form.seats') }}</th>
                  <th data-field="remaining" data-sortable="false">{{ trans('admin/licenses/form.remaining_seats') }}</th>
                  <th data-field="purchase_date" data-sortable="true">{{ trans('admin/licenses/table.purchase_date') }}</th>
                  <th data-field="purchase_cost" data-sortable="true">{{ trans('admin/licenses/form.cost') }}</th>
                  <th data-field="purchase_order" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.purchase_order') }}</th>
                  <th data-field="expiration_date" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.expiration') }}</th>
                  <th data-field="notes" data-sortable="true" data-visible="false">{{ trans('admin/licenses/form.notes') }}</th>
                  <th data-field="actions">{{ trans('table.actions') }}</th>
              </tr>
          </thead>
      </table>
    </div><!-- /.box-body -->
    <div class="box-footer clearfix">

    </div>
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
        pageSize: {{ \App\Models\Setting::getSettings()->per_page }},
        pagination: true,
        sidePagination: 'server',
        sortable: true,
        cookie: true,
        mobileResponsive: true,
        showExport: true,
        showColumns: true,
        exportDataType: 'all',
        exportTypes: ['csv', 'txt','json', 'xml'],
        exportOptions: {
            fileName: 'licenses-export-' + (new Date()).toISOString().slice(0,10),
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

@stop

@stop
