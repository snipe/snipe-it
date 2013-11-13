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
			<a href="#" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Create</a>
		</div>
	</h3>
</div>

{{ $models->links() }}

<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th class="span6">@lang('admin/models/table.title')</th>
			<th class="span2">@lang('admin/models/table.modelnumber')</th>
			<th class="span2">@lang('admin/models/table.created_at')</th>
			<th class="span2">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($models as $model)
		<tr>
			<td>{{ $model->name }}</td>
			<td>{{ $model->modelno }}</td>
			<td>{{ $model->created_at->diffForHumans() }}</td>
			<td>
				<a href="#" class="btn btn-mini">@lang('button.edit')</a>
				<a href="#" class="btn btn-mini btn-danger">@lang('button.delete')</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

{{ $models->links() }}
@stop
