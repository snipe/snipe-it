@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.entities') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/entity') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('actions.create')</a>
        <h3>@lang('base.entities')</h3>
    </div>
</div>


<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

<table id="example">
    <thead>
        <tr role="row">
            <th class="col-md-3">@lang('base.entity')</th>
            <th class="col-md-3">@lang('general.name')</th>
            <th class="col-md-2">@lang('base.locations')</th>
            <th class="col-md-2 actions">@lang('actions.actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($entities as $entity)
        <tr>
            <td><a href="{{ route('view/entity', $entity->id) }}">{{{ $entity->common_name }}}</a></td>
            <td>{{{ $entity->name }}}</td>
            <td>{{ $entity->has_locations() }}</td>
            <td>
                <a href="{{ route('update/entity', $entity->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                <a data-html="false" class="btn delete-asset btn-danger"
                    @if($entity->isRequired())
                    disabled='true'
                    @endif
                    data-toggle="modal" 
                    href="{{ route('delete/entity', $entity->id) }}" 
                    data-content="@lang('admin/entities/message.delete.confirm')"
                    data-title="@lang('actions.delete')
                    {{ htmlspecialchars($entity->name) }}?" 
                    onClick="return false;"><i class="icon-trash icon-white"></i></a>

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>


<!-- side address column -->
<div class="col-md-3 col-xs-12 address pull-right">
    <h4>@lang('base.entity_about')</h4>
    <br>
    <p>@lang('admin/entities/message.about') </p>

</div>

</div>
    
</div>

@stop
