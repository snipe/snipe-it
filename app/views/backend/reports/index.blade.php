@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.depreciation_report') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="page-header">

    <div class="pull-right">
        <a href="{{ route('reports/export') }}" class="btn btn-flat gray pull-right"><i class="icon-download-alt"></i>
        @lang('actions.download')</a>
        </div>

    <h3>@lang('base.depreciation_report')</h3>
</div>

<div class="row table">
<div class="col-md-12">
<table id="example">
        <thead>
            <tr role="row">
            <th class="col-sm-1">@lang('general.asset_tag')</th>
            <th class="col-sm-1">@lang('general.hardware')</th>
            @if (Setting::getSettings()->display_asset_name)
                <th class="col-sm-1">@lang('general.name')</th>
            @endif
            <th class="col-sm-1">@lang('general.serialnumber')</th>
            <th class="col-sm-1">@lang('general.assignedto')</th>
            <th class="col-sm-1">@lang('base.location')</th>
            <th class="col-sm-1">@lang('general.purchasedate')</th>
            <th class="col-sm-1">@lang('general.eol')</th>
            <th class="col-sm-1">@lang('general.purchasecost')</th>
            <th class="col-sm-1">@lang('admin/hardware/form.book_value')</th>
            <th class="col-sm-1">@lang('admin/hardware/form.diff')</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($assets as $asset)
        <tr>
            <td>{{{ $asset->asset_tag }}}</td>
            <td>{{{ $asset->model->name }}}</td>
            @if (Setting::getSettings()->display_asset_name)
                <td>{{{ $asset->name }}}</td>
            @endif
            <td>{{ $asset->serial }}</td>
            <td>
            @if ($asset->assigned_to != 0)
                <a href="{{ route('view/user', $asset->assigned_to) }}">
                {{{ $asset->assigneduser->fullName() }}}
                </a>
            @endif
            </td>
            <td>
            @if (($asset->assigned_to > 0) && ($asset->assigneduser->location_id > 0)) {{{ Location::find($asset->assigneduser->location_id)->city }}}
                    ,
                    {{{ Location::find($asset->assigneduser->location_id)->state }}}
            @endif
            </td>
            <td>{{{ $asset->purchase_date }}}</td>

            <td>
            @if ($asset->model->eol) {{{ $asset->eol_date() }}}
            @endif
            </td>

            @if ($asset->purchase_cost > 0)
            <td class="align-right">@lang('general.currency')
            {{{ number_format($asset->purchase_cost) }}}</td>
            <td class="align-right">@lang('general.currency')
            {{{ number_format($asset->depreciate()) }}}</td>
            <td class="align-right">@lang('general.currency')
            -{{{ number_format(($asset->purchase_cost - $asset->depreciate())) }}}</td>
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


@stop
