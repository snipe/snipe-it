@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.manufacturers') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/manufacturer') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('actions.create')</a>
        <h3>@lang('base.manufacturers')</h3>
    </div>
</div>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9 bio">
            <table id="example">
                <thead>
                    <tr role="row">
                        <th class="col-md-4">@lang('base.manufacturer')</th>
                        <th class="col-md-2">@lang('base.assets_shortname')</th>
                        <th class="col-md-2">@lang('base.licenses_shortname')</th>
                        <th class="col-md-1 actions">@lang('actions.actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($manufacturers as $manufacturer)
                    <tr>
                        <td><a href="{{ route('view/manufacturer', $manufacturer->id) }}" class="name">{{{ $manufacturer->name }}}</a> </td>
                        <td>{{ $manufacturer->has_models()}}</td>
                        <td>{{ $manufacturer->has_licenses()}}</td>
                        <td>
                            <a href="{{ route('update/manufacturer', $manufacturer->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                            <a data-html="false" 
                               @if($manufacturer->has_models() || $manufacturer->has_licenses())
                                    disabled="true"
                               @endif 
                               class="btn delete-asset btn-danger" 
                               data-toggle="modal" href="{{ route('delete/manufacturer', $manufacturer->id) }}" 
                               data-content="@lang('admin/manufacturers/message.delete.confirm')"
                               data-title="@lang('actions.delete')
                                {{ htmlspecialchars($manufacturer->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
            <br />
            <h6>@lang('base.manufacturer_about')</h6>
            <p>@lang('admin/manufacturers/message.about') </p>

        </div>

    </div>
</div>


@stop
