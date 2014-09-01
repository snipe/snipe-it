@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Locations ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">          
        @if (Input::get('onlyTrashed'))
            <a data-html="false" 
               class="btn delete-asset btn-danger pull-right" 
               data-toggle="modal" 
               href="{{ route('purge/locations', null) }}" 
               data-content="@choice('message.purge.confirm', $locations->count())" 
               title="@choice('message.purge.confirm', $locations->count())"
               data-title="@lang('button.purge')?" onClick="return false;"><i class="icon-trash icon-white"></i>
               @lang('button.purge')
            </a>
            <a class="btn btn-default pull-right" href="{{ URL::to('/admin/settings/locations') }}">
                {{ Lang::get('button.show_deleted')}}</a>
        @else
            <a href="{{ route('create/location') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('general.create')</a>
            <a class="btn btn-default pull-right" href="{{ URL::to('admin/settings/locations?onlyTrashed=true') }}">@lang('button.show_current')</a>
        @endif

        <h3>
        @if (Input::get('onlyTrashed'))
            @lang('general.deleted')
        @else
            @lang('general.locations')
        @endif
    </div>
</div>

<div class="row form-wrapper">

<table id="example">
    <thead>
        <tr role="row">
            <th class="col-md-3">@lang('admin/locations/table.name')</th>
            <th class="col-md-3">@lang('general.entity')</th>
            <th class="col-md-3">@lang('admin/locations/table.address')</th>
            <th class="col-md-2">@lang('admin/locations/table.city'),
            @lang('admin/locations/table.state')
            @lang('admin/locations/table.country')</th>
            <th class="col-md-2 actions">@lang('table.actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($locations as $location)
        <tr>
            <td><a href="{{ route('view/location', $location->id) }}" class="name">{{{ $location->name }}}</a></td>
            <td>@if ($location->entity_id) 
                <a href="{{ route('view/entity', $location->entity->id) }}" class="name">{{{ $location->entity->common_name }}}</a>
                 
                @endif</td>
            <td>{{{ $location->address }}}, {{{ $location->address2 }}}  </td>
            <td>{{{ $location->city }}}, {{{ $location->state }}}  {{{ $location->country }}}  </td>
            <td>
                @if (is_null($location->deleted_at))
                            <a href="{{ route('update/location', $location->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                            <a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" 
                               href="{{ route('delete/location', $location->id) }}" data-content="@lang('message.delete.confirm')" 
                                data-title="@lang('general.delete')
                            {{ htmlspecialchars($location->name) }}?" 
                            @if($location->isRequired())
                            disabled='true'
                            @endif
                            onClick="return false;"><i class="icon-trash icon-white"></i></a>
                @else
                            <a href="{{ route('restore/location', $location->id) }}" class="btn btn-warning"><i class="icon-share-alt icon-white"></i></a>
                            <a data-html="false" class="btn delete-asset btn-danger" 
                               data-toggle="modal" href="{{ route('delete/location', $location->id) }}" data-content="@choice('message.purge.confirm',1)" 
                            data-title="@lang('general.purge')
                            {{ htmlspecialchars($location->name) }}?" 
                            @if($location->isRequired())
                            disabled='true'
                            @endif
                            onClick="return false;"><i class="icon-remove icon-white"></i></a>
                @endif           

            </td>
        </tr>
        @endforeach
    </tbody>
</table>
</div>


@stop
