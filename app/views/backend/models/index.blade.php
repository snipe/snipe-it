@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.models') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('create/model') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('actions.create')</a>
        <h3>@lang('base.models')</h3>
    </div>
</div>

<div class="user-profile">
<div class="row profile">
    <div class="col-md-9 bio">
<table id="example">
    <thead>
        <tr role="row">
            <th class="col-md-3">@lang('base.model_shortname')</th>
            <th class="col-md-2">@lang('general.modelnumber')</th>
            <th class="col-md-1">@lang('general.count')</th>
            <!--<th class="col-md-2">@lang('base.depreciation')</th>-->
            <th class="col-md-2">@lang('base.category_shortname')</th>
            <!--<th class="col-md-2">@lang('general.eol')</th>-->
            <th class="col-md-2 actions">@lang('actions.actions')</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($models as $model)
        <tr>
            <td><a href="{{ route('view/model', $model->id) }}">{{{ $model->name }}}</a></td>
            <td>{{{ $model->modelno }}}</td>
            <td>{{ ($model->assets->count()) }}</td>
            <!--<td>
            @if (($model->depreciation) && ($model->depreciation->id > 0)) {{{ $model->depreciation->name }}}
                ({{{ $model->depreciation->months }}}
                @lang('general.months')
                )
            @else
             @lang('general.no_depreciation')
            @endif
            </td>-->
            <td>
            @if ($model->category) {{{ $model->category->name }}}
            @endif
            </td>
            <!--<td>
            @if ($model->eol) {{{ $model->eol }}}
                @lang('general.months')
            @else
             --
            @endif
            </td>-->
            <td>
                <a href="{{ route('update/model', $model->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
                <a data-html="false" class="btn delete-asset btn-danger" 
                   @if($model->has_assets())
                    disabled='disabled'
                   @endif
                   data-toggle="modal" href="{{ route('delete/model', $model->id) }}" data-content="@lang('admin/models/message.delete.confirm')"
                data-title="@lang('actions.delete')
                {{ htmlspecialchars($model->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
 
</div>

<!-- side address column -->
<div class="col-md-3 col-xs-12 address pull-right">
    <br />
    <h6>@lang('base.model_about')</h6>
    <p>@lang('admin/models/message.about') </p>

</div>

</div>
</div>
@stop
