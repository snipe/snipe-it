@extends('backend/layouts/default')

@section('title0')
    @if (Input::get('Pending') || Input::get('Undeployable') || Input::get('available')  || Input::get('Deployed') || Input::get('onlyTrashed'))
        @if (Input::get('onlyTrashed'))
            @lang('general.deleted')
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

    @lang('base.licenses')
    
@stop

{{-- Page title --}}
@section('title')
    @yield('title0') :: @parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        
         @if (Input::get('onlyTrashed'))
            <a data-html="false" 
               class="btn delete-asset btn-danger pull-right" 
               data-toggle="modal" 
               href="{{ route('purge/license', null) }}" 
               data-content="@choice('message.purge.confirm', $licenses->count())" 
               title="@choice('message.purge.confirm', $licenses->count())"
               data-title="@lang('actions.purge')?" onClick="return false;"><i class="icon-trash icon-white"></i>
               @lang('actions.purge')
            </a>
            <a class="btn btn-default pull-right" href="{{ URL::to('admin/licenses') }}">
                {{ Lang::get('actions.showcurrent')}}</a>
        @else
            <a href="{{ route('create/licenses') }}" title="@lang('actions.create')" class="btn btn-success pull-right">
                <i class="icon-plus-sign icon-white"></i>
                @lang('actions.create')
            </a>
            <a class="btn btn-default pull-right" href="{{ URL::to('admin/licenses?onlyTrashed=true') }}">@lang('actions.showdeleted')</a>
        @endif
        
        <h3>@yield('title0')</h3>
        
    </div>
</div>

<div class="row form-wrapper">

<table id="example">
    <thead>
        <tr role="row">
            <th class="col-md-3" tabindex="0" rowspan="1" colspan="1">@lang('general.name')</th>
            <th class="col-md-3" tabindex="0" rowspan="1" colspan="1">@lang('general.serialnumber')</th>
            <th class="col-md-2" tabindex="0" rowspan="1" colspan="1">@lang('general.hardware')</th>
            <th class="col-md-2" tabindex="0" rowspan="1" colspan="1">@lang('general.assignedto')</th>
            <th class="col-md-1 actions" tabindex="0" rowspan="1" colspan="1">@lang('general.in_out')</th>
            <th class="col-md-1 actions" tabindex="0" rowspan="1" colspan="1">@lang('actions.actions')</th>
        </tr>
    </thead>
    <tbody>


        @foreach ($licenses as $license)
                
                @if ($license->licenseseats)
                <?php $count=1; ?>
                @foreach ($license->licenseseats as $licensedto)

                <tr>

                    <td><a href="{{ route('view/license', $license->id) }}">{{{ $license->name }}}</a>
                     (Seat {{ $count }})
                     </td>
                    <td><a href="{{ route('view/license', $license->id) }}">{{ Str::limit(e($license->serial, 40)); }}</a>
                    </td>
                    <td>
                     @if ($licensedto->asset_id)
                        <a href="{{ route('view/hardware', $licensedto->asset_id) }}">
                        @if($licensedto->asset)                      
                            {{{ $licensedto->asset->asset_tag }}}

                            @if (Setting::getSettings()->display_asset_name)
                                                            ({{{ $licensedto->asset->name }}})
                            @endif
                        @endif
                    	</a>
                    @endif
                    </td>
                    <td>
                    @if (($licensedto->assigned_to) && ($licensedto->deleted_at == NULL))
                        <a href="{{ route('view/user', $licensedto->assigned_to) }}">
                    {{{ $licensedto->user->fullName() }}}
                    </a>
                    @elseif (($licensedto->assigned_to) && ($licensedto->deleted_at != NULL))
                        <del>{{{ $licensedto->user->fullName() }}}</del>
                    @elseif ($licensedto->asset)
                                        @if ($licensedto->asset->assigned_to != 0)
                                            <a href="{{ route('view/user', $licensedto->asset->assigned_to) }}">
                                                {{{ $licensedto->asset->assigneduser->fullName() }}}
                                            </a>
                                        @endif
                                        @else 
                                        
                                    @endif
                                    



                    </td>
                    <td>
                    @if (is_null($licensedto->deleted_at))                         
                        @if (($licensedto->assigned_to) || ($licensedto->asset_id))
                            <a href="{{ route('checkin/license', $licensedto->id) }}" class="btn btn-primary">
                            @lang('actions.checkin')</a>
                        @else
                            <a href="{{ route('checkout/license', $licensedto->id) }}" class="btn btn-info">
                            @lang('actions.checkout')</a>
                        @endif
                    @endif
                    
                    </td>
                    <td>
                    @if ($count==1)
                        @if (is_null($licensedto->deleted_at))
                            <a href="{{ route('update/license', $license->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                            <a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/license', $license->id) }}" data-content="@lang('admin/licenses/message.delete.confirm')" 
                            data-title="@lang('actions.delete')
                            {{ htmlspecialchars($license->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
                        @else
                            <a href="{{ route('restore/license', $license->id) }}" class="btn btn-warning"><i class="icon-share-alt icon-white"></i></a>
                            <a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/license', $license->id) }}" data-content="@choice('message.purge.confirm',1)" 
                            data-title="@lang('actions.purge')
                            {{ htmlspecialchars($license->name) }}?" onClick="return false;"><i class="icon-remove icon-white"></i></a>
                        @endif
                    @endif
                    </td>

                </tr>
                <?php $count++; ?>
                @endforeach
                @endif

        @endforeach

    </tbody>
</table>

@stop
