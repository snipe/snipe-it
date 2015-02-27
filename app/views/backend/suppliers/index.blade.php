@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/suppliers/table.suppliers') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/supplier') }}" class="btn btn-success pull-right"><i class="fa fa-plus icon-white"></i>  @lang('general.create')</a>
        <h3>@lang('admin/suppliers/table.suppliers')</h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-12">

@if ($suppliers->count() >= 1)
<table id="example">
    <thead>
        <tr role="row">
            <th class="col-md-3">@lang('admin/suppliers/table.name')</th>
            <th class="col-md-3">@lang('admin/suppliers/table.address')</th>
            <th class="col-md-3">@lang('admin/suppliers/table.contact')</th>
            <th class="col-md-3">@lang('admin/suppliers/table.phone')</th>
            <th class="col-md-3">@lang('admin/suppliers/table.assets')</th>
            <th class="col-md-3">@lang('admin/suppliers/table.licenses')</th>
            <th class="col-md-2 actions">@lang('table.actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($suppliers as $supplier)
        <tr>
            <td><a href="{{ route('view/supplier', $supplier->id) }}">
            {{{ $supplier->name }}}
            </a></td>
            <td>{{{ $supplier->address }}}

            @if (($supplier->address2) || ($supplier->city) || ($supplier->state))

                 {{{ $supplier->city }}}
                 {{{ $supplier->state }}}  {{{ $supplier->zip }}}
            @endif
            </td>
            <td>
            @if ($supplier->email)
                <a href="mailto:{{{ $supplier->email }}}">
                {{{ $supplier->contact }}}
                </a>
            @else {{{ $supplier->contact }}}
            @endif
            </td>
            <td>{{{ $supplier->phone }}}</td>
            <td>{{{ $supplier->num_assets() }}}</td>
            <td>{{{ $supplier->num_licenses() }}}</td>
            <td>
                <a href="{{ route('update/supplier', $supplier->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-pencil icon-white"></i></a>
                <a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="{{ route('delete/supplier', $supplier->id) }}" data-content="@lang('admin/suppliers/message.delete.confirm')"
                data-title="@lang('general.delete')
                 {{ htmlspecialchars($supplier->name) }}?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>


            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
        @lang('general.no_results')

        @endif
</div>



</div>


@stop
