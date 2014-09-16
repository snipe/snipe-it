@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.suppliers') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/supplier') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i> @lang('actions.create')</a>
        <h3>@lang('base.suppliers')</h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

@if ($suppliers->count() >= 1)

<table id="example">
    <thead>
        <tr role="row">
            <th class="col-md-2">@lang('general.name')</th>
            <th class="col-md-2">@lang('general.contact')</th>
            <th class="col-md-2">@lang('general.phone')</th>
            <th class="col-md-1">@lang('admin/suppliers/form.hw-sw')</th>
            <th class="col-md-1 actions">@lang('actions.actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($suppliers as $supplier)
        <tr>
            <td><a href="{{ route('view/supplier', $supplier->id) }}">
            {{{ $supplier->name }}}
            </a></td>
            
            <td>
            @if ($supplier->email)
                <a href="mailto:{{{ $supplier->email }}}">
                {{{ $supplier->contact }}}
                </a>
            @else {{{ $supplier->contact }}}
            @endif
            </td>
            <td>{{{ $supplier->phone }}}</td>
            <td>{{{ $supplier->num_assets() }}} / {{{ $supplier->num_licenses() }}}</td>
            <td>
                <a href="{{ route('update/supplier', $supplier->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                <a data-html="false" 
                   @if($supplier->num_assets() || $supplier->num_licenses())
                        disabled="true"
                   @endif
                   class="btn delete-asset btn-danger" 
                   data-toggle="modal" href="{{ route('delete/supplier', $supplier->id) }}" 
                   data-content="@lang('admin/suppliers/message.delete.confirm')"
                   data-title="@lang('actions.delete')
                   {{ htmlspecialchars($supplier->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>


            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
@lang('general.no_results')
@endif

</div>

<!-- side address column -->
<div class="col-md-3 col-xs-12 address pull-right">
    <br />
    <h6>@lang('base.supplier_about')</h6>
    <p>@lang('admin/suppliers/message.about') </p>

</div>

</div>
</div>

@stop
