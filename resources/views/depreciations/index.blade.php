@extends('layouts/default')

{{-- Page title --}}
@section('title')
Asset Depreciations
@parent
@stop

@section('header_right')
<a href="{{ route('create/depreciations') }}" class="btn btn-primary pull-right">
  {{ trans('general.create') }}</a>
@stop


{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">
    <div class="box box-default">
      <div class="box-body">
        <div class="table-responsive">
          <table
          name="depreciations"
          class="table table-striped"
          id="table"
          data-url="{{ route('api.depreciations.list') }}"
          data-cookie="true"
          data-cookie-id-table="depreciationsTable-{{ config('version.hash_version') }}">
            <thead>
              <tr>
                <th data-sortable="true" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                <th data-sortable="true" data-field="name">{{ trans('admin/depreciations/table.title') }}</th>
                <th data-sortable="false" data-field="months">{{ trans('admin/depreciations/table.term') }}</th>
                <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>


  <!-- side address column -->
  <div class="col-md-3">
      <h4>{{ trans('admin/depreciations/general.about_asset_depreciations') }}</h4>
      <p>{{ trans('admin/depreciations/general.about_depreciations') }} </p>
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
        fileName: 'depreciations-export-' + (new Date()).toISOString().slice(0,10),
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
