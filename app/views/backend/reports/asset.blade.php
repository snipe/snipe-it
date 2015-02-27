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
<table id="example">
        <thead>
            <tr role="row">
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
            <th class="col-sm-1">@lang('general.status')</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($assets as $asset)
        <tr>
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
            <td class="align-right">@lang('general.currency')
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
            @if (($asset->assigned_to > 0) && ($asset->assigneduser->location_id > 0))
                {{{ $asset->assigneduser->userLoc->name }}}
            @elseif ($asset->rtd_location_id)
                {{{ $asset->defaultLoc->name }}}
            @endif
            </td>
            <td>
                @if (($asset->status_id == '0') && ($asset->assigned_to == '0'))
                    @lang('general.ready_to_deploy')
                @elseif (($asset->status_id == '') && ($asset->assigned_to == '0'))
                    @lang('general.pending')
                @elseif ($asset->assetstatus)
                    {{{ $asset->assetstatus->name }}}
                @endif
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

</div>

@stop