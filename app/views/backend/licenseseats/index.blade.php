@extends('backend/layouts/default')

@section('title0')
    @if (Input::get('Pending') || Input::get('Undeployable') || Input::get('available')  || Input::get('Deployed') || Input::get('onlyTrashed'))
        @if (Input::get('onlyTrashed'))
            @lang('actions.deleted')
        @elseif (Input::get('Pending'))
            @lang('general.pending')
        @elseif (Input::get('available'))
            @lang('general.readytodeploy')
        @elseif (Input::get('Undeployable'))
            @lang('general.undeployable')
        @elseif (Input::get('Deployed'))
            @lang('general.deployed')
        @endif
    @else
            @lang('general.all')
    @endif

    @lang('base.licenseseats')
    
@stop

{{-- Page title --}}
@section('title')
    @yield('title0') :: @parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        
         
        <h3>@yield('title0')</h3>
    </div>
</div>

<div class="row form-wrapper">

<table id="example">
    <thead>
        <tr role="row">
            <th class="col-md-3" tabindex="0" rowspan="1" colspan="1">@lang('general.name')</th>
            <th class="col-md-3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/form.serial')</th>
            <th class="col-md-2" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/form.hardware')</th>
            <th class="col-md-2" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/form.assigned_to')</th>
            <th class="col-md-1 actions" tabindex="0" rowspan="1" colspan="1">@lang('general.in_out')</th>
            
        </tr>
    </thead>
    <tbody>


        @foreach ($seats as $seat)
                
                
                

                <tr>

                    <td><a href="{{ route('view/license', $seat->license->id) }}">{{{ $seat->license->name }}}</a>
                                          </td>
                    <td><a href="{{ route('view/license', $seat->license->id) }}">{{ Str::limit(e($seat->license->serial, 40)); }}</a>
                    </td>
                    <td>
                     @if ($seat->asset_id)
                        <a href="{{ route('view/hardware', $seat->asset_id) }}">
                        @if($seat->asset)                      
                            {{{ $seat->asset->asset_tag }}}

                            @if (Setting::getSettings()->display_asset_name)
                                                            ({{{ $seat->asset->name }}})
                            @endif
                        @endif
                    	</a>
                    @endif
                    </td>
                    <td>
                    @if (($seat->assigned_to) && ($seat->deleted_at == NULL))
                        <a href="{{ route('view/user', $seat->assigned_to) }}">
                    {{{ $seat->user->fullName() }}}
                    </a>
                    @elseif (($seat->assigned_to) && ($seat->deleted_at != NULL))
                        <del>{{{ $seat->user->fullName() }}}</del>
                    @elseif ($seat->asset)
                                        @if ($seat->asset->assigned_to != 0)
                                            <a href="{{ route('view/user', $seat->asset->assigned_to) }}">
                                                {{{ $seat->asset->assigneduser->fullName() }}}
                                            </a>
                                        @endif
                                        @else 
                                        
                                    @endif
                                    



                    </td>
                    <td>
                    @if (is_null($seat->deleted_at))                         
                        @if (($seat->assigned_to) || ($seat->asset_id))
                            <a href="{{ route('checkin/license', $seat->id) }}" class="btn btn-primary">
                            @lang('actions.checkin')</a>
                        @else
                            <a href="{{ route('checkout/license', $seat->id) }}" class="btn btn-info">
                            @lang('actions.checkout')</a>
                        @endif
                    @endif
                    
                    </td>
                </tr>
        @endforeach
    </tbody>
</table>

@stop
