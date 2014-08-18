@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Entities ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/entity') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('general.create')</a>
        <h3>@lang('admin/entities/table.entities')</h3>
    </div>
</div>

<div class="row form-wrapper">

<table id="example">
    <thead>
        <tr role="row">
            <th class="col-md-3">@lang('admin/entities/table.common_name')</th>
            <th class="col-md-3">@lang('admin/entities/table.name')</th>
            <th class="col-md-2">@lang('admin/entities/table.notes')</th>
            <th class="col-md-2 actions">@lang('table.actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($entities as $entity)
        <tr>
            <td>{{{ $entity->common_name }}}</td>
            <td>{{{ $entity->name }}}</td>
            <td>{{{ $entity->notes }}}</td>
            <td>
                <a href="{{ route('update/entity', $entity->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                <a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/entity', $entity->id) }}" data-content="@lang('admin/entities/message.delete.confirm')"
                data-title="@lang('general.delete')
                 {{ htmlspecialchars($entity->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>


@stop
