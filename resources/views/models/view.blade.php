@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('admin/models/table.view') }}
{{ $model->model_tag }}
@parent
@stop

@section('header_right')
<<<<<<< HEAD
=======
    @can('superuser')
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
  <div class="btn-group pull-right">
     <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">{{ trans('button.actions') }}
          <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
          @if ($model->deleted_at=='')
              <li><a href="{{ route('update/model', $model->id) }}">{{ trans('admin/models/table.edit') }}</a></li>
              <li><a href="{{ route('clone/model', $model->id) }}">{{ trans('admin/models/table.clone') }}</a></li>
              <li><a href="{{ route('create/hardware', $model->id) }}">{{ trans('admin/hardware/form.create') }}</a></li>
          @else
              <li><a href="{{ route('restore/model', $model->id) }}">{{ trans('admin/models/general.restore') }}</a></li>
          @endif
      </ul>
  </div>
<<<<<<< HEAD
=======
    @endcan
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
@stop

{{-- Page content --}}
@section('content')

  <div class="row">
    <div class="col-md-9">
      <div class="box box-default">

          @if ($model->id)
            <div class="box-header with-border">
              <div class="box-heading">
                <h3 class="box-title"> {{ $model->name }}</h3>
              </div>
            </div><!-- /.box-header -->
          @endif


        <div class="box-body">
          <table
          name="modelassets"
          id="table"
          data-url="{{route('api.models.view', $model->id)}}"
          data-cookie="true"
          data-click-to-select="true"
          data-cookie-id-table="modeldetailsViewTable">
                <thead>
                    <tr>

                        <th data-sortable="false" data-field="companyName" data-searchable="false" data-visible="false">{{ trans('admin/companies/table.title') }}</th>
                        <th data-sortable="true" data-field="id" data-searchable="false" data-visible="false">{{ trans('general.id') }}</th>
                        <th data-sortable="true" data-field="name" data-searchable="true">{{ trans('general.name') }}</th>
                        <th data-sortable="true" data-field="asset_tag">{{ trans('general.asset_tag') }}</th>
                        <th data-sortable="true" data-field="serial">{{ trans('admin/hardware/table.serial') }}</th>
                        <th data-sortable="false" data-field="assigned_to">{{ trans('general.user') }}</th>
                        <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ trans('table.actions') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
  </div>
</div>

  <!-- side address column -->
  <div class="col-md-3">
  <h4>More Info:</h4>
    <ul class="list-unstyled">

      @if ($model->manufacturer)
      <li>{{ trans('general.manufacturer') }}:
      {{ $model->manufacturer->name }}</li>
      @endif

      @if ($model->modelno)
      <li>{{ trans('general.model_no') }}:
      {{ $model->modelno }}</li>
      @endif

      @if ($model->depreciation)
      <li>{{ trans('general.depreciation') }}:
      {{ $model->depreciation->name }} ({{ $model->depreciation->months }}
      {{ trans('general.months') }}
      )</li>
      @endif

      @if ($model->eol)
      <li>{{ trans('general.eol') }}:
      {{ $model->eol }}
      {{ trans('general.months') }}</li>
      @endif

      @if ($model->image)
      <li><br /><img src="{{ config('app.url') }}/uploads/models/{{ $model->image }}" class="img-responsive"></li>
      @endif

      @if  ($model->deleted_at!='')
         <li><br /><a href="{{ route('restore/model', $model->id) }}" class="btn-flat large info ">{{ trans('admin/models/general.restore') }}</a></li>

  	@endif

    </ul>

    @if ($model->note)
    Notesd:
    <p>{!! $model->getNote() !!}
    </p>
    @endif

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
