@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.families') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/family') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('actions.create')</a>
        <h3>@lang('base.families')</h3>
    </div>
</div>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9 bio">

<table id="example">
    <thead>
        <tr role="row">
            <th class="col-md-4">@lang('general.common_name')</th>
            <th class="col-md-2">@lang('general.name')</th>
            <th class="col-md-2">@lang('base.family_use')</th>
            <th class="col-md-1 actions">@lang('actions.actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($families as $family)
        <tr>
            <td>{{ HTML::linkAction('view/family', $family->common_name, array($family->id)) }}</td>
            <td>{{{ $family->name }}}</td>
            <td>{{ $family->has_licenses() }}</td>
            <td>
                <a href="{{ route('update/family', $family->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                <a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/family', $family->id) }}" data-content="@lang('admin/families/message.delete.confirm')"
                data-title="@lang('actions.delete')
                 {{ htmlspecialchars($family->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>

        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
            <br />
            <h6>@lang('base.family_about')</h6>
            <p>@lang('admin/families/message.about') </p>
        </div>
        
</div>
</div>


@stop
