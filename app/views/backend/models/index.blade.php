@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/models/table.title') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
    	<a href="{{ route('create/model') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('general.create')</a>
		<h3>@lang('admin/models/table.title')</h3>
	</div>
</div>

<div class="row form-wrapper">
<table id="example">
	<thead>
		<tr role="row">
			<th class="col-md-3">@lang('admin/models/table.title')</th>
			<th class="col-md-2">@lang('admin/models/table.modelnumber')</th>
			<th class="col-md-1">@lang('admin/models/table.numassets')</th>
			<th class="col-md-2">@lang('general.depreciation')</th>
			<th class="col-md-2">@lang('general.category')</th>
			<th class="col-md-2">@lang('general.eol')</th>
			<th class="col-md-2 actions">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($models as $model)
		<tr>
			<td><a href="{{ route('view/model', $model->id) }}">{{{ $model->name }}}</a></td>
			<td>{{ $model->modelno }}</td>
			<td><a href="{{ route('view/model', $model->id) }}">{{ ($model->assets->count()) }}</a></td>
			<td>

			@if (($model->depreciation) && ($model->depreciation->id > 0))
				{{ $model->depreciation->name }}
			 	({{ $model->depreciation->months }} months)
			@else
			 @lang('general.no_depreciation')
			@endif

			</td>
			<td>
			@if ($model->category)
			{{ $model->category->name }}
			@endif
			</td>

			<td>

			@if ($model->eol)
			 	{{ $model->eol }}
			 	@lang('general.months')
			@else
			 --
			@endif

			</td>

			<td>
				<a href="{{ route('update/model', $model->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
				<a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/model', $model->id) }}" data-content="@lang('admin/models/message.delete.confirm')"
				data-title="@lang('general.delete')
				{{ htmlspecialchars($model->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@stop
