@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Asset Models ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		Asset Models

		<div class="pull-right">
			<a href="{{ route('create/model') }}" class="btn-flat success"><i class="icon-plus-sign icon-white"></i> Create New</a>
		</div>
	</h3>
</div>
@if ($models->getTotal() > Setting::getSettings()->per_page)
{{ $models->links() }}
@endif

<div class="row-fluid table">
<table class="table table-hover">
	<thead>
		<tr>
			<th class="span3">@lang('admin/models/table.title')</th>
			<th class="span3"><span class="line"></span>@lang('admin/models/table.modelnumber')</th>
			<th class="span1"><span class="line"></span>@lang('admin/models/table.numassets')</th>
			<th class="span2"><span class="line"></span>@lang('admin/models/table.created_at')</th>
			<th class="span3"><span class="line"></span>@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($models as $model)
		<tr>
			<td>{{ $model->name }}</td>
			<td>{{ $model->modelno }}</td>
			<td>{{ ($model->assets->count()) }}</td>
			<td>{{ $model->created_at->diffForHumans() }}</td>
			<td>
				<a href="{{ route('update/model', $model->id) }}" class="btn-flat white">@lang('button.edit')</a>
				<a class="btn-flat danger delete-asset" data-toggle="modal" href="{{ route('delete/model', $model->id) }}" data-content="Are you sure you wish to delete the  {{ $model->name }} model?" data-title="Delete {{ $model->name }}?" onClick="return false;">@lang('button.delete')</a>

			</td>
		</tr>
		@endforeach
	</tbody>
</table>


@if ($models->getTotal() > Setting::getSettings()->per_page)
{{ $models->links() }}
@endif

@stop
