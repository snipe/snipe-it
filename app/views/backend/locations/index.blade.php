@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.locations') ::
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
               data-title="@lang('actions.purge')?" onClick="return false;"><i class="icon-trash icon-white"></i>
               @lang('actions.purge')
            </a>
            <a class="btn btn-default pull-right" href="{{ URL::to('/admin/settings/locations') }}">
                {{ Lang::get('actions.showcurrent')}}</a>
        @else
            <a href="{{ route('create/location') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('actions.create')</a>
            <a class="btn btn-default pull-right" href="{{ URL::to('admin/settings/locations?onlyTrashed=true') }}">@lang('actions.showdeleted')</a>
        @endif

        <h3>
        @if (Input::get('onlyTrashed'))
            @lang('base.locations')
            :
            @lang('general.deleted')
        @else
            @lang('base.locations')
        @endif
    </div>
</div>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9 bio">

<table id="example">
    <thead>
        <tr role="row">
            <th class="col-md-3">@lang('general.name')</th>
            <th class="col-md-3">@lang('base.entity')</th>
            <th class="col-md-3">@lang('general.city')</th>
            <th class="col-md-2 actions">@lang('actions.actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($locations as $location)
        <tr>
            <td><a href="{{ route('view/location', $location->id) }}" class="name">{{{ $location->name }}}</a></td>
            <td>@if ($location->entity_id) 
                <a href="{{ route('view/entity', $location->entity->id) }}" class="name">{{{ $location->entity->common_name }}}</a> 
                @endif</td>
            <td>{{{ $location->city }}}</td>
            <td>
                @if (is_null($location->deleted_at))
                            <a href="{{ route('update/location', $location->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                            <a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" 
                               href="{{ route('delete/location', $location->id) }}" data-content="@lang('message.delete.confirm')" 
                                data-title="@lang('actions.delete')
                            {{ htmlspecialchars($location->name) }}?" 
                            @if($location->isRequired())
                            disabled='true'
                            @endif
                            onClick="return false;"><i class="icon-trash icon-white"></i></a>
                @else
                            <a href="{{ route('restore/location', $location->id) }}" class="btn btn-warning"><i class="icon-share-alt icon-white"></i></a>
                            <a data-html="false" class="btn delete-asset btn-danger" 
                               data-toggle="modal" href="{{ route('delete/location', $location->id) }}" data-content="@choice('message.purge.confirm',1)" 
                            data-title="@lang('actions.purge')
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

        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
            <h4>@lang('base.location_about')</h4>
            <br />
            <p>@lang('admin/locations/message.about') </p>

        </div>

    </div>
</div>


@stop
