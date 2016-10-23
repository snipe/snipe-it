@extends('layouts/default')

{{-- Page title --}}
@section('title')

 {{ $category->name }}
 {{ trans('general.assets') }}
@parent
@stop

@section('header_right')
<div class="btn-group pull-right">
   <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
            <li><a href="{{ route('update/category', $category->id) }}">{{ trans('admin/categories/general.edit') }}</a></li>
            <li><a href="{{ route('create/category') }}">{{ trans('general.create') }}</a></li>
    </ul>
</div>
@stop

{{-- Page content --}}
@section('content')


  <div class="row">
    <div class="col-md-12">
      <div class="box box-default">
        <div class="box-body">


          <table
          name="category_assets"
          id="table"
          data-url="{{ route('api.categories.'.$category->category_type.'.view', [$category->id, $category->category_type]) }}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="categoryAssetsTable">
              <thead>
                  <tr>
                      <th data-searchable="false" data-sortable="false" data-field="companyName" data-visible="false">
                          {{ trans('admin/companies/table.title') }}
                      </th>
                      <th data-searchable="false" data-sortable="false" data-field="id" data-visible="false">{{ trans('general.id') }}</th>
                      <th data-searchable="false" data-sortable="false" data-field="name">{{ trans('general.name') }}</th>
                      @if ($category->category_type=='asset')
                      <th data-searchable="false" data-sortable="false" data-field="model">{{ trans('admin/hardware/form.model') }}</th>
                      <th data-searchable="false" data-sortable="false" data-field="asset_tag">{{ trans('general.asset_tag') }}</th>
                      <th data-searchable="false" data-sortable="false" data-field="serial">{{ trans('admin/hardware/form.serial') }}</th>
                      <th data-searchable="false" data-sortable="false" data-field="assigned_to">{{ trans('general.user') }}</th>
                      <th data-searchable="false" data-sortable="false" data-field="change"  data-switchable="false">{{ trans('admin/hardware/table.change') }}</th>
                      @endif
                      <th data-searchable="false" data-sortable="false" data-field="actions"  data-switchable="false">{{ trans('table.actions') }}</th>
                  </tr>
              </thead>
          </table>
        </div>
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
          //search: true,
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
