@extends('backend/layouts/default')

{{-- Web site Title --}}
@section('title')
Group Management ::
@parent
@stop

{{-- Content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
    	<a href="{{ route('create/group') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i> Create New</a>
		<h3>Group Management</h3>
	</div>
</div>



<div class="row form-wrapper">
<table id="example">
	<thead>
		<tr role="row">
			<th class="col-md-6">@lang('admin/groups/table.name')</th>
			<th class="col-md-1">@lang('admin/groups/table.users')</th>
			<th class="col-md-2">@lang('admin/groups/table.created_at')</th>
			<th class="col-md-3">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@if ($groups->count() >= 1)
		@foreach ($groups as $group)
		<tr>
			<td>{{ $group->name }}</td>
			<td>{{ $group->users()->count() }}</td>
			<td>{{ $group->created_at->diffForHumans() }}</td>
			<td>
				<a href="{{ route('update/group', $group->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
				<a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/group', $group->id) }}" data-content="Are you sure you wish to delete this group?" data-title="Delete {{ htmlspecialchars($group->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
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
