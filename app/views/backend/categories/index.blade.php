@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Asset Categories ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		Asset Categories

		<div class="pull-right">
			<a href="{{ route('create/category') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Create</a>
		</div>
	</h3>
</div>
@if (count($categories) > 10)
{{ $categories->links() }}
@endif
<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th class="span1">@lang('admin/categories/table.id')</th>
			<th class="span2">@lang('admin/categories/table.title')</th>
			<th class="span2">@lang('admin/categories/table.parent')</th>
			<th class="span2">@lang('admin/categories/table.created_at')</th>
			<th class="span2">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($categories as $category)
		<tr>
			<td>{{ $category->id }}</td>
			<td>{{ $category->name }}</td>
			<td>

			@if (is_object($category->parentname))
				{{ $category->parentname->name }}
			@else
				Top Level
			@endif

			</td>

			<td>{{ $category->created_at->diffForHumans() }}</td>
			<td>
				<a href="{{ route('update/category', $category->id) }}" class="btn btn-mini">@lang('button.edit')</a>
				<a href="{{ route('delete/category', $category->id) }}" class="btn btn-mini btn-danger">@lang('button.delete')</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@if (count($categories) > 10)
{{ $categories->links() }}
@endif
@stop
