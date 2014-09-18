@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.entity') {{ $entity->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('update/entity', $entity->id) }}" class="btn btn-warning pull-right">
        @lang('actions.update')</a>
        <h3 class="name">@lang('base.entity') 
            : 
            {{{ $entity->name }}} </h3>
    </div>
</div>

<div class="user-profile">
    <div class="row profile">

        <div class="col-md-9 bio">
               <!-- checked out assets table -->
        <h6>{{{Lang::get('base.entity_use')}}} : {{$entity->has_locations()}}</h6>
        @if ($entity->locations)
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="col-md-2">@lang('base.location')</th>
                        <th class="col-md-2">@lang('general.city')</th>
                    </tr>
                </thead>
                    @foreach ($entity->locations as $location)
                        <tr> 
                            <td><a href="{{ route('view/location', $location->id) }}" class="name">{{{ $location->name }}}</a></td>
                            <td>{{{ $location->city }}} </td>
                        </tr>
                    @endforeach
                    
                </table>
        
                            @else
                    <div class="col-md-10"><br>
                        <div class="alert alert-info alert-block">
                            <i class="icon-info-sign"></i>
                            @lang('general.no_results')
                        </div>
                    </div>        
                    
        @endif
        
        <br> 
        </div>

        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
        <h6>@lang('general.moreinfo'):</h6>
        <ul>
            @if ($entity->name)
                <li>@lang('general.name'): {{ $entity->name }} </li>
            @endif
            @if ($entity->common_name)
                <li>@lang('general.common_name'): {{ $entity->common_name }} </li>
            @endif
            @if ($entity->name)
                <li>@lang('general.notes'): {{ $entity->notes }} </li>
            @endif
        </ul>
        </div>
    </div>
</div>
@stop
