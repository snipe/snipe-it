@extends('backend/layouts/default')


@section('title0')
    @if (Input::get('Pending') || Input::get('Undeployable') || Input::get('RTD')  || Input::get('Deployed') || Input::get('onlyTrashed'))
        @if (Input::get('onlyTrashed'))
            @lang('general.deleted')
        @elseif (Input::get('Pending'))
            @lang('general.pending')
        @elseif (Input::get('RTD'))
            @lang('general.readytodeploy')
        @elseif (Input::get('Undeployable'))
            @lang('general.undeployable')
        @elseif (Input::get('Deployed'))
            @lang('general.deployed')
        @endif
    @else
            @lang('general.all')
    @endif

    @lang('base.assets')
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
               href="{{ route('purge/hardware', null) }}" 
               data-content="@choice('message.purge.confirm', $assets->count())" 
               title="@choice('message.purge.confirm', $assets->count())"
               data-title="@lang('actions.purge')?" onClick="return false;"><i class="icon-trash icon-white"></i>
               @lang('actions.purge')
            </a>
            <a class="btn btn-default pull-right" href="{{ URL::to('hardware') }}">
                {{ Lang::get('actions.showcurrent')}}</a>
        @else
            <a href="{{ route('create/hardware') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i> @lang('actions.create')</a>
            <a class="btn btn-default pull-right" href="{{ URL::to('hardware?onlyTrashed=true') }}">@lang('actions.showdeleted')</a>
        @endif

        
        <h3>@yield('title0')</h3>
    </div>
</div>

<div class="row form-wrapper">
    <div class="col-md-12">
        @if ($assets->count() > 0) 
       
        <table id="example">
            <thead>
                <tr role="row">
                    <th class="col-md-1" bSortable="true">@lang('general.asset_tag')</th>
                    <th class="col-md-1" bSortable="true">@lang('base.model')</th>
                    @if (Setting::getSettings()->display_asset_name)
                    <th class="col-md-1" bSortable="true">@lang('general.name')</th>                
                    @endif
                    <th class="col-md-1" bSortable="true">@lang('admin/hardware/form.serial')</th>                    
                    <th class="col-md-1" bSortable="true">@lang('admin/hardware/form.checkoutto')</th>
                    <th class="col-md-1" bSortable="true">@lang('base.statuslabels')</th>                    
                    <th class="col-md-1">@lang('general.eol')</th>
                    <th class="col-md-1">@lang('base.category')</th>
                    <th class="col-md-1">@lang('admin/hardware/form.change')</th>
                    <th class="col-md-1 actions" bSortable="false">@lang('actions.actions')</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assets as $asset)
                <tr>
                    <td><a href="{{ route('view/hardware', $asset->id) }}">{{ $asset->asset_tag }}</a></td>
                    <td><a href="{{ route('view/model', $asset->model->id) }}">{{ $asset->model->name }}</a></td>
                    @if (Setting::getSettings()->display_asset_name)
                        <td><a href="{{ route('view/hardware', $asset->id) }}">{{ $asset->name }}</a></td>
                    @endif
                    <td>{{ $asset->serial }}</td>
                    <td>
                        @if ($asset->assigneduser)
                            <a href="{{ route('view/user', $asset->assigned_to) }}">
                            {{{ $asset->assigneduser->fullName() }}}
                            </a>
                         @endif 
                    </td>
                    <td>
                        @if($asset->assetstatus)
                        {{ $asset->assetstatus->name; }}
                        @endif
                    </td>
                    <td>
                    @if ($asset->model->eol) {{{ $asset->eol_date() }}}
                    @endif
                    </td>
                    <td>
                        @if($asset->model->category)
                        {{ $asset->model->category->name }}
                        @endif
                    </td>
                    <td>
                        @if($asset->state)
                        {{ $asset->state->getCheckoutButton() }}     
                        @else
                        no state
                        @endif
                        
                    </td>
                    <td nowrap="nowrap">
                        @if($asset->state)
                        {{ $asset->state->getStatusButton() }}   
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="col-md-9">
        <div class="alert alert-info alert-block">
            <i class="icon-info-sign"></i>
            @lang('general.no_results')
        </div>
    </div>
    @endif
</div>



@stop
