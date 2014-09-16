@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.location') : {{ $location->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('update/location', $location->id) }}" class="btn btn-warning pull-right">@lang('actions.update')</a>
        <h3 class="name">@lang('base.location') :      
        {{{ $location->name }}} </h3>
    </div>
</div>


<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

 
                <!-- checked out assets table -->
                <h6>[@lang('base.location_use')
                    @if($location->has_users() > 0) 
                        : {{ $location->has_users() }}  
                    @endif]</h6>
               <div class="row-fluid table users-list">
<table id="example">
    <thead>
        <tr role="row">
            <th class="col-md-3">@lang('general.name')</th>
            <th class="col-md-2">@lang('general.email')</th>
            <th class="col-md-2">@lang('admin/users/form.manager')</th>
            <th class="col-md-1">@lang('base.asset_shortname')</th>
            <th class="col-md-1">@lang('base.license_shortname')</th>
            <th class="col-md-1">@lang('admin/users/form.activated')</th>
            
        </tr>
    </thead>
    <tbody>
        @if($location->has_users() > 0)
        @foreach ($location->users as $user)
        <tr>
            <td>
            <img src="{{ $user->gravatar() }}" class="img-circle avatar hidden-phone" style="max-width: 45px;" />
            <a href="{{ route('view/user', $user->id) }}" class="name">{{{ $user->fullName() }}}</a>

            </td>
            <td>{{ HTML::mailto($user->email) }}</td>
            <td>
            @if ($user->manager) 
                <a href="{{ route('view/user', $user->manager->id) }}" class="name">{{{ $user->manager->fullName() }}}                
            @endif
            </td>
            <td>{{{ $user->assets->count() }}}</td>
            <td>{{{ $user->licenses->count() }}}</td>
            <td>{{ $user->isActivated() ? '<i class="icon-ok"></i>' : ''}}</td>
           

           
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
</div>
                <br>             
        </div>

        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
        <h6><br>@lang('general.moreinfo'):</h6>
            <table>
                    <tr>
                        <td><strong>@lang('general.name'):</strong></td>
                        <td> {{ $location->name }}</td>
                    </tr>
                    @if($location->entity)
                    <tr>
                        <td><strong>@lang('base.entity'):</strong></td>
                        <td><a href="{{ route('view/entity', $location->entity->id) }}" class="name">{{{ $location->entity->common_name }}}</a></td></tr>
                    @endif
                    @if($location->address)
                    <tr>
                        <td><strong>@lang('general.address'):</strong></td><td> {{$location->address }}</td>
                    </tr>
                    @endif
                    @if($location->address2)
                    <tr>
                        <td>&nbsp;</td>
                        <td>{{$location->address2 }}</td></tr>
                    @endif
                    
                    @if($location->city)
                    <tr><td><strong>@lang('general.city'):</strong></td><td> {{$location->city }}</td></tr>
                    @endif
                     @if($location->state)
                    <tr><td><strong>@lang('general.state'):</strong></td><td> {{$location->state }}</td></tr>
                    @endif
                    @if($location->country)
                    <tr><td><strong>@lang('general.country'):</strong></td><td> {{$location->country }}</td></tr>
                    @endif
                     @if($location->zip)
                    <tr><td><strong>@lang('general.postalcode'):</strong></td><td> {{$location->zip }}</td></tr>
                    @endif
                </table>
        </div>
    </div>
</div>
@stop
