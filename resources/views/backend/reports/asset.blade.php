@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('general.asset_report') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="page-header">

    <div class="pull-right">
        <a href="{{ route('reports/export/assets') }}" class="btn btn-flat gray pull-right"><i class="fa fa-download icon-white"></i>
        @lang('admin/hardware/table.dl_csv')</a>
    </div>

    <h3>@lang('general.asset_report')</h3>
</div>

<div class="row">

<div class="table-responsive">
      <table
      name="assetReport"
      id="table"
      data-cookie="true"
      data-click-to-select="true"
      data-cookie-id-table="assetReportTable">

        <thead>
            <tr role="row">
            <th class="col-sm-1">@lang('admin/companies/table.title')</th>
            <th class="col-sm-1">@lang('admin/hardware/table.asset_tag')</th>
            <th class="col-sm-1">@lang('admin/hardware/form.manufacturer')</th>
            <th class="col-sm-1">@lang('admin/hardware/form.model')</th>
            <th class="col-sm-1">@lang('general.model_no')</th>
            @if (Setting::getSettings()->display_asset_name)
                <th class="col-sm-1">@lang('general.name')</th>
            @endif
            <th class="col-sm-1">@lang('admin/hardware/table.serial')</th>
             <th class="col-sm-1">@lang('admin/hardware/table.status')</th>
            <th class="col-sm-1">@lang('admin/hardware/table.purchase_date')</th>
            <th class="col-sm-1">@lang('admin/hardware/table.purchase_cost')</th>
            <th class="col-sm-1">@lang('admin/hardware/form.order')</th>
            <th class="col-sm-1">@lang('admin/hardware/form.supplier')</th>
            <th class="col-sm-1">@lang('admin/hardware/table.checkoutto')</th>
            <th class="col-sm-1">@lang('admin/hardware/table.location')</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($assets as $asset)
        <tr>
            <td>{{{ is_null($asset->company) ? '' : $asset->company->name }}}</td>
            <td>{{{ $asset->asset_tag }}}</td>
            <td>
            @if ($asset->model->manufacturer)
                {{{ $asset->model->manufacturer->name }}}
            @endif
            </td>
            <td>{{{ $asset->model->name }}}</td>
            <td>{{{ $asset->model->modelno }}}</td>
            @if (Setting::getSettings()->display_asset_name)
                <td>{{{ $asset->name }}}</td>
            @endif
            <td>{{ $asset->serial }}</td>
            <td>

            @if ($asset->assetstatus)
            	{{{ $asset->assetstatus->name }}}
            @elseif ($asset->assigneduser)
				{{{ $asset->assigneduser->fullName() }}}
            @endif
            </td>
            <td>{{{ $asset->purchase_date }}}</td>
            <td class="align-right">{{{ Setting::first()->default_currency }}}
                {{{ number_format($asset->purchase_cost) }}}
            </td>
            <td>
                @if ($asset->order_number)
                    {{{ $asset->order_number }}}
                @endif
            </td>
            <td>
                @if ($asset->supplier_id)
                    <a href="{{ route('view/supplier', $asset->supplier_id) }}">
                    {{{ $asset->supplier->name }}}
                    </a>
                @endif
            </td>
            <td>
             @if ($asset->assigneduser)
            	 @if ($asset->assigneduser->deleted_at!='')
            	 	<del>{{{ $asset->assigneduser->fullName() }}}</del>
            	 @else
            	 	<a href="{{ route('view/user', $asset->assigned_to) }}">
					{{{ $asset->assigneduser->fullName() }}}
					</a>
            	 @endif

            @endif
            </td>
            <td>
            @if (($asset->assigneduser) && ($asset->assigneduser->userLoc))
              {{{ $asset->assigneduser->userLoc->name }}}
            @elseif ($asset->defaultLoc)
              {{{ $asset->defaultLoc->name }}}
            @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

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
        sidePagination: 'client',
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
