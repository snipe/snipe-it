@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Families ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/family') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('general.create')</a>
        <h3>@lang('general.families')</h3>
    </div>
</div>

<div class="row form-wrapper">

<table id="example">
    <thead>
        <tr role="row">
            <th class="col-md-3">@lang('admin/families/table.common_name')</th>
            <th class="col-md-3">@lang('admin/families/table.name')</th>
            <th class="col-md-2">@lang('admin/families/table.notes')</th>
            <th class="col-md-2 actions">@lang('table.actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($families as $family)
        <tr>
            <td>{{{ $family->common_name }}}</td>
            <td>{{{ $family->name }}}</td>
            <td>{{{ $family->notes }}}</td>
            <td>
                <a href="{{ route('update/family', $family->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                <a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/family', $family->id) }}" data-content="@lang('admin/families/message.delete.confirm')"
                data-title="@lang('general.delete')
                 {{ htmlspecialchars($family->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>


@stop
