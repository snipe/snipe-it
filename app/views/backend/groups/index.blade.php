@extends('backend/layouts/default')

{{-- Web site Title --}}
@section('title')
Group Management ::
@parent
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h3>
		Group Management

		<div class="pull-right">
			<a href="{{ route('create/group') }}" class="btn-flat success"><i class="icon-plus-sign icon-white"></i> Create New</a>
		</div>
	</h3>
</div>


<div class="row-fluid table">
<table id="example">
	<thead>
		<tr role="row">
			<th class="span1">@lang('admin/groups/table.id')</th>
			<th class="span6">@lang('admin/groups/table.name')</th>
			<th class="span2">@lang('admin/groups/table.users')</th>
			<th class="span2">@lang('admin/groups/table.created_at')</th>
			<th class="span2">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@if ($groups->count() >= 1)
		@foreach ($groups as $group)
		<tr>
			<td>{{ $group->id }}</td>
			<td>{{ $group->name }}</td>
			<td>{{ $group->users()->count() }}</td>
			<td>{{ $group->created_at->diffForHumans() }}</td>
			<td>
				<a href="{{ route('update/group', $group->id) }}" class="btn-flat white">@lang('button.edit')</a>
				<a class="btn-flat danger delete-asset" data-toggle="modal" href="{{ route('delete/group', $group->id) }}" data-content="Are you sure you wish to delete the  {{ $group->name }} group?" data-title="Delete {{ $group->name }}?" onClick="return false;">@lang('button.delete')</a>
			</td>
		</tr>
		@endforeach
		@else
		<tr>
			<td colspan="5">No results</td>
		</tr>
		@endif
	</tbody>
</table>
</div>


@stop
