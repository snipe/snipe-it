@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/models/table.view')
{{{ $model->model_tag }}} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<!--<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('update/model', $model->id) }}" class="btn btn-warning pull-right">
        @lang('admin/models/table.update')</a>
        <h3 class="name">@lang('general.history_for')
        {{{ $model->name }}} </h3>
    </div>
</div>-->
<div class="row header">
    <div class="col-md-12">
        <div class="btn-group pull-right">
            <button class="btn gray">@lang('button.actions')</button>
            <button class="btn glow dropdown-toggle" data-toggle="dropdown">
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">    
                    <li><a href="{{ route('update/model', $model->id) }}">@lang('admin/models/table.edit')</a></li>  
                    <li><a href="{{ route('clone/model', $model->id) }}">@lang('admin/models/table.clone')</a></li>    
            </ul>
        </div>
        <h3>
        
            @lang('admin/models/table.view')        
        
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
                                        <th class="col-md-3">@lang('general.user')</th>
                                        <th class="col-md-2">@lang('table.actions')</th>
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
                                            <a href="{{ route('checkin/hardware', $modelassets->id) }}" class="btn-flat info">Checkin</a>
                                        @else
                                            <a href="{{ route('checkout/hardware', $modelassets->id) }}" class="btn-flat success">Checkout</a>
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
                                <li>@lang('general.manufacturer'):
                                {{ $model->manufacturer->name }}</li>
                                @endif

                                @if ($model->modelno)
                                <li>@lang('general.model_no'):
                                {{ $model->modelno }}</li>
                                @endif

                                @if ($model->depreciation)
                                <li>@lang('general.depreciation'):
                                {{ $model->depreciation->name }} ({{ $model->depreciation->months }} months)</li>
                                @endif

                                @if ($model->eol)
                                <li>@lang('general.eol'):
                                {{ $model->eol }} months</li>
                                @endif

                                @if ($model->image)
                                <li><br /><img src="/uploads/models/{{{ $model->image }}}" /></li>
                                @endif

                            </ul>

                    </div>
@stop
