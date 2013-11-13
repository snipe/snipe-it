@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Blog Management ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
	<h3>
		Blog Management

		<div class="pull-right">
			<a href="{{ route('create/blog') }}" class="btn btn-small btn-info"><i class="icon-plus-sign icon-white"></i> Create</a>
		</div>
	</h3>
</div>

{{ $posts->links() }}

<table class="table table-bordered table-striped table-hover">
	<thead>
		<tr>
			<th class="span6">@lang('admin/blogs/table.title')</th>
			<th class="span2">@lang('admin/blogs/table.comments')</th>
			<th class="span2">@lang('admin/blogs/table.created_at')</th>
			<th class="span2">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($posts as $post)
		<tr>
			<td>{{ $post->title }}</td>
			<td>{{ $post->comments()->count() }}</td>
			<td>{{ $post->created_at->diffForHumans() }}</td>
			<td>
				<a href="{{ route('update/blog', $post->id) }}" class="btn btn-mini">@lang('button.edit')</a>
				<a href="{{ route('delete/blog', $post->id) }}" class="btn btn-mini btn-danger">@lang('button.delete')</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

{{ $posts->links() }}
@stop
