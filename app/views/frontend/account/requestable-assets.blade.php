@extends('backend/layouts/default')

@section('title0')
            @lang('admin/hardware/general.requestable')
    @lang('general.assets')
@stop

{{-- Page title --}}
@section('title')
    @yield('title0') :: @parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        <h3>@yield('title0')</h3>
    </div>
</div>

<div class="row form-wrapper">

@if ($assets->count() > 0)

<div class="table-responsive">
<table id="example">

    <thead>
        <tr role="row">
            <th class="col-md-3" bSortable="true">@lang('admin/hardware/table.asset_model')</th>
            @if (Setting::getSettings()->display_asset_name)
            <th class="col-md-3" bSortable="true">@lang('general.name')</th>
            @endif
            <th class="col-md-2" bSortable="true">@lang('admin/hardware/table.serial')</th>
            <th class="col-md-2" bSortable="true">@lang('admin/hardware/table.location')</th>
            <th class="col-md-2 actions" bSortable="false">@lang('table.actions')</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($assets as $asset)
        <tr>
            <td>{{{ $asset->model->name }}}</td>

            @if (Setting::getSettings()->display_asset_name)
                <td>{{{ $asset->name }}}</td>
            @endif

            <td>{{{ $asset->serial }}}</td>
            <td>
                @if ($asset->assigneduser && $asset->assetloc)
                    	{{{ $asset->assetloc->name }}}
                @elseif ($asset->defaultLoc)
                    	{{{ $asset->defaultLoc->name }}}

                @endif

            </td>
            <td>
                <a href="{{ route('account/request-asset', $asset->id) }}" class="btn btn-info btn-sm" title="@lang('button.request')">@lang('button.request')</a>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
</div>
@else
<div class="col-md-9">
    <div class="alert alert-info alert-block">
        <i class="fa fa-info-circle"></i>
        @lang('general.no_results')
    </div>
</div>

</div>

@endif


@stop
