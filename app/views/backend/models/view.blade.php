@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.model')
{{{ $model->name }}} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<!--<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('update/model', $model->id) }}" class="btn btn-warning pull-right">
        @lang('admin/models/table.update')</a>
        <h3 class="name">@lang('general.history')
        {{{ $model->name }}} </h3>
    </div>
</div>-->
<div class="row header">
    <div class="col-md-12">
        <div class="btn-group pull-right">
            <button class="btn gray">@lang('actions.actions')</button>
            <button class="btn glow dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">    
                    <li><a href="{{ route('update/model', $model->id) }}">@lang('base.model_update')</a></li>  
                    <li><a href="{{ route('clone/model', $model->id) }}">@lang('base.model_clone')</a></li>    
            </ul>
        </div>
        <h3>
        
            @lang('base.model') : 
            {{{ $model->name }}}
        
        </h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">


                            <!-- checked out models table -->
                            @if (count($model->assets) > 0)
                           <table id="example">
                            <thead>
                                <tr role="row">
                                        <th class="col-md-3">@lang('general.name')</th>
                                        <th class="col-md-3">@lang('general.asset_tag')</th>
                                        <th class="col-md-3">@lang('base.user')</th>
                                        <th class="col-md-2">@lang('actions.actions')</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($model->assets as $modelassets)
                                    <tr>
                                        <td><a href="{{ route('view/hardware', $modelassets->id) }}">{{{ $modelassets->name }}}</a></td>
                                        <td><a href="{{ route('view/hardware', $modelassets->id) }}">{{{ $modelassets->asset_tag }}}</a></td>
                                        <td>
                                        @if ($modelassets->assigneduser)
                                        <a href="{{ route('view/user', $modelassets->assigned_to) }}">
                                        {{{ $modelassets->assigneduser->fullName() }}}
                                        </a>
                                        @endif
                                        </td>
                                        <td>
                                        @if ($modelassets->assigned_to != 0)
                                            <a href="{{ route('checkin/hardware', $modelassets->id) }}" class="btn btn-primary">@lang('actions.checkin')</a>
                                        @else
                                            <a href="{{ route('checkout/hardware', $modelassets->id) }}" class="btn btn-info">@lang('actions.checkout')</a>
                                        @endif
                                        </td>

                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>

                            @else
                            <div class="col-md-9">
                                <div class="alert alert-info alert-block">
                                    <i class="icon-info-sign"></i>
                                    @lang('general.no_results')
                                </div>
                            </div>
                            @endif

                        </div>


                    <!-- side address column -->
                    <div class="col-md-3 col-xs-12 address pull-right">
                    <h6>More Info:</h6>
                               <ul>


                                @if ($model->manufacturer)
                                <li>@lang('base.manufacturer'):
                                {{ $model->manufacturer->name }}</li>
                                @endif

                                @if ($model->modelno)
                                <li>@lang('general.modelnumber'):
                                {{ $model->modelno }}</li>
                                @endif

                                @if ($model->depreciation)
                                <li>@lang('base.depreciation'):
                                {{ $model->depreciation->name }} ({{ $model->depreciation->months }} months)</li>
                                @endif

                                @if ($model->eol)
                                <li>@lang('general.eol'):
                                {{ $model->eol }} months</li>
                                @endif

                            </ul>

    <br />
    <h6>@lang('base.model_about')</h6>
    <p>@lang('admin/models/message.about') </p>

                    </div>
@stop
