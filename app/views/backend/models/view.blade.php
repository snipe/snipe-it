@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/models/table.view')
{{{ $model->model_tag }}} ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <div class="btn-group pull-right">
           <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">@lang('button.actions')
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                @if ($model->deleted_at=='')
                    <li><a href="{{ route('update/model', $model->id) }}">@lang('admin/models/table.edit')</a></li>
                    <li><a href="{{ route('clone/model', $model->id) }}">@lang('admin/models/table.clone')</a></li>
                    <li><a href="{{ route('create/hardware', $model->id) }}">@lang('admin/hardware/form.create')</a></li>
                @else
                    <li><a href="{{ route('restore/model', $model->id) }}">@lang('admin/models/general.restore')</a></li>
                @endif
            </ul>
        </div>
        <h3>

            @lang('admin/models/table.view') -
            {{{ $model->name }}}

        </h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

    @if ($model->deleted_at!='')
			<div class="alert alert-warning alert-block">
				<i class="fa fa-warning"></i>
				@lang('admin/models/general.deleted', array('model_id' => $model->id))

			</div>

		@endif


          <!-- checked out models table -->
          @if (count($model->assets) > 0)
          	<table
            name="modelassets"
            id="table"
            data-url="{{route('api.models.view', $model->id)}}"
            data-cookie="true"
            data-click-to-select="true"
            data-cookie-id-table="modeldetailsViewTable">
                  <thead>
                      <tr>

                          <th data-sortable="false" data-field="companyName" data-searchable="false" data-visible="false">{{{ Lang::get('admin/companies/table.title') }}}</th>
                          <th data-sortable="true" data-field="id" data-searchable="false" data-visible="false">{{Lang::get('general.id')}}</th>
                          <th data-sortable="true" data-field="name" data-searchable="true">{{Lang::get('general.name')}}</th>
                          <th data-sortable="true" data-field="asset_tag">{{Lang::get('general.asset_tag')}}</th>
                          <th data-sortable="true" data-field="serial">{{Lang::get('admin/hardware/table.serial')}}</th>
                          <th data-sortable="false" data-field="assigned_to">{{Lang::get('general.user')}}</th>
                          <th data-switchable="false" data-searchable="false" data-sortable="false" data-field="actions">{{ Lang::get('table.actions') }}</th>
                      </tr>
                  </thead>
              </table>
          @else
          <div class="col-md-9">
              <div class="alert alert-info alert-block">
                  <i class="fa fa-info-circle"></i>
                  @lang('general.no_results')
              </div>
          </div>
          @endif


      </div>


  <!-- side address column -->
  <div class="col-md-3 col-xs-12 address pull-right">
  <h6>More Info:</h6>
    <ul>


      @if ($model->manufacturer)
      <li>@lang('general.manufacturer'):
      {{ $model->manufacturer->name }}</li>
      @endif

      @if ($model->modelno)
      <li>@lang('general.model_no'):
      {{ $model->modelno }}</li>
      @endif

      @if ($model->depreciation)
      <li>@lang('general.depreciation'):
      {{ $model->depreciation->name }} ({{ $model->depreciation->months }}
      @lang('general.months')
      )</li>
      @endif

      @if ($model->eol)
      <li>@lang('general.eol'):
      {{ $model->eol }}
      @lang('general.months')</li>
      @endif

      @if ($model->image)
      <li><br /><img src="{{ Config::get('app.url') }}/uploads/models/{{{ $model->image }}}" /></li>
      @endif

      @if  ($model->deleted_at!='')
         <li><br /><a href="{{ route('restore/model', $model->id) }}" class="btn-flat large info ">@lang('admin/models/general.restore')</a></li>

  	@endif

    </ul>

    @if ($model->note)
    Notes:
    <p>{{ $model->getNote() }}
    </p>
    @endif

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
          pageSize: {{{ Setting::getSettings()->per_page }}},
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
          paginationFirstText: "@lang('general.first')",
          paginationLastText: "@lang('general.last')",
          paginationPreText: "@lang('general.previous')",
          paginationNextText: "@lang('general.next')",
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
