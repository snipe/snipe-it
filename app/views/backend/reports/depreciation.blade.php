@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('general.depreciation_report') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="page-header">
    <h3>@lang('general.depreciation_report')</h3>
</div>

<div class="row">

<div class="table-responsive">
      <table
      name="depreciationReport"
      id="table"
      data-cookie="true"
      data-click-to-select="true"
      data-cookie-id-table="depreciationReportTable">
        <thead>
            <tr role="row">
            <th class="col-sm-1">@lang('admin/companies/table.title')</th>
            <th class="col-sm-1">@lang('admin/hardware/table.asset_tag')</th>
            <th class="col-sm-1">@lang('admin/hardware/table.title')</th>
            @if (Setting::getSettings()->display_asset_name)
                <th class="col-sm-1">@lang('general.name')</th>
            @endif
            <th class="col-sm-1">@lang('admin/hardware/table.serial')</th>
            <th class="col-sm-1">@lang('admin/hardware/table.checkoutto')</th>
            <th class="col-sm-1">@lang('admin/hardware/table.location')</th>
            <th class="col-sm-1">@lang('admin/hardware/table.purchase_date')</th>
            <th class="col-sm-1">@lang('admin/hardware/table.eol')</th>
            <th class="col-sm-1">@lang('admin/hardware/table.purchase_cost')</th>
            <th class="col-sm-1">@lang('admin/hardware/table.book_value')</th>
            <th class="col-sm-1">@lang('admin/hardware/table.diff')</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($assets as $asset)
        <tr>
            <td>{{{ is_null($asset->company) ? '' : $asset->company->name }}}</td>
            <td>
	            @if ($asset->deleted_at!='')
	            	 <del>{{{ $asset->asset_tag }}}</del>
	            @else
	            	 {{{ $asset->asset_tag }}}
	            @endif

	        </td>
            <td>{{{ $asset->model->name }}}</td>
            @if (Setting::getSettings()->display_asset_name)
                <td>{{{ $asset->name }}}</td>
            @endif
            <td>{{ $asset->serial }}</td>
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
                @if ($asset->assetloc)
                    {{{ $asset->assetloc->name }}}
                @elseif ($asset->defaultloc)
                    {{{ $asset->defaultloc->name }}}
                @endif
            </td>
            <td>{{{ $asset->purchase_date }}}</td>

            <td>
            @if ($asset->model->eol) {{{ $asset->eol_date() }}}
            @endif
            </td>

            @if ($asset->purchase_cost > 0)
            <td class="align-right">
                @if ($asset->assetloc )
                    {{{ $asset->assetloc->currency }}}
                @else
                    {{{ Setting::first()->default_currency }}}
                @endif
            	{{{ number_format($asset->purchase_cost) }}}</td>
            <td class="align-right">
                @if ($asset->assetloc )
                    {{{ $asset->assetloc->currency }}}
                @else
                    {{{ Setting::first()->default_currency }}}
                @endif

            	{{{ number_format($asset->getDepreciatedValue()) }}}</td>
            <td class="align-right">
                @if ($asset->assetloc)
                    {{{ $asset->assetloc->currency }}}
                @else
                    {{{ Setting::first()->default_currency }}}
                @endif

            	-{{{ number_format(($asset->purchase_cost - $asset->getDepreciatedValue())) }}}</td>
            @else
	            <td></td>
	            <td></td>
	            <td></td>
            @endif


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
        classes: 'table table-responsive table-striped table-bordered',
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
