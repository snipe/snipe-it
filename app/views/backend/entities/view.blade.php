@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/entities/table.general_info') {{ $entity->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('update/entity', $entity->id) }}" class="btn btn-warning pull-right">
        @lang('admin/entities/table.update')</a>
        <h3 class="name">        
        {{{ $entity->name }}} </h3>
    </div>
</div>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9 bio">

            <h6>@lang('admin/entities/table.general_info')</h6>

                <div class="col-md-12">
                                  
                </div>
        </div>
        <div class="col-md-9 bio">
               <!-- checked out assets table -->
            <h6> @lang('admin/locations/table.locations')</h6>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="col-md-2">@lang('admin/locations/table.name')</th>
                        <th class="col-md-3">@lang('admin/locations/table.address')</th>
                        <th class="col-md-2">@lang('admin/locations/table.city'),
                        @lang('admin/locations/table.state')
                        @lang('admin/locations/table.country')</th>
                    </tr>
                </thead>
                @if ($entity->locations)
                    @foreach ($entity->locations as $location)
                        <tr> 
                            <td>{{{ $location->name }}}</td>
                            <td>{{{ $location->address }}}, {{{ $location->address2 }}}  </td>
                            <td>{{{ $location->city }}}, {{{ $location->state }}}  {{{ $location->country }}}  </td>
                        </tr>
                    @endforeach
                @endif
                </table>
                <br>
            
                
        </div>

        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
        <h6><br>@lang('general.moreinfo'):</h6>
        <ul>
            @if ($entity->name)
                <li>@lang('admin/entities/table.name'): {{ $entity->name }} </li>
            @endif
            @if ($entity->common_name)
                <li>@lang('admin/entities/table.common_name'): {{ $entity->common_name }} </li>
            @endif
            @if ($entity->name)
                <li>@lang('admin/entities/table.notes'): {{ $entity->notes }} </li>
            @endif
            
        </div>
    </div>
</div>
@stop
