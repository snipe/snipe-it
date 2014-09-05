@extends('backend/layouts/default')

{{-- Page title --}}
@lang('admin/licenses/general.software_licenses') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
        
         
        <h3>@lang('admin/licenses/general.license_seats')</h3>
    </div>
</div>

<div class="row form-wrapper">

<table id="example">
    <thead>
        <tr role="row">
            <th class="col-md-3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.title')</th>
            <th class="col-md-3" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.serial')</th>
            <th class="col-md-2" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.hardware')</th>
            <th class="col-md-2" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/table.assigned_to')</th>
            <th class="col-md-1 actions" tabindex="0" rowspan="1" colspan="1">@lang('admin/licenses/general.in_out')</th>
            <th class="col-md-1 actions" tabindex="0" rowspan="1" colspan="1">@lang('table.actions')</th>
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
                        <a href="{{ route('view/user', $licensedto->assigned_to) }}">
                    {{{ $seat->user->fullName() }}}
                    </a>
                    @elseif (($seat->assigned_to) && ($seat->deleted_at != NULL))
                        <del>{{{ $licensedto->user->fullName() }}}</del>
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
                            @lang('general.checkin')</a>
                        @else
                            <a href="{{ route('checkout/license', $seat->id) }}" class="btn btn-info">
                            @lang('general.checkout')</a>
                        @endif
                    @endif
                    
                    </td>
                    <td>
                    
                        @if (is_null($seat->deleted_at))
                            <a href="{{ route('update/license', $seat->license->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                            <a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/license', $seat->license->id) }}" data-content="@lang('admin/licenses/message.delete.confirm')" 
                            data-title="@lang('general.delete')
                            {{ htmlspecialchars($seat->license->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
                        @else
                            <a href="{{ route('restore/license', $seat->license->id) }}" class="btn btn-warning"><i class="icon-share-alt icon-white"></i></a>
                            <a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/license', $seat->license->id) }}" data-content="@choice('message.purge.confirm',1)" 
                            data-title="@lang('general.purge')
                            {{ htmlspecialchars($seat->license->name) }}?" onClick="return false;"><i class="icon-remove icon-white"></i></a>
                        @endif
                    
                    </td>



                </tr>
               


        @endforeach







    </tbody>
</table>

@stop
