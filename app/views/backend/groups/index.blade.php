@extends('backend/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('admin/groups/titles.group_management') ::
@parent
@stop

{{-- Content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
    	<a href="{{ route('create/group') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i> @lang('general.create')</a>
		<h3>@lang('admin/groups/titles.group_management')</h3>
	</div>
</div>



<div class="row form-wrapper">
<table id="example">
	<thead>
		<tr role="row">
			<th class="col-md-3">@lang('admin/groups/table.name')</th>
			<th class="col-md-2">@lang('admin/groups/table.users')</th>
			<th class="col-md-2">@lang('general.created_at')</th>
			<th class="col-md-1 actions">@lang('table.actions')</th>
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
				<a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/group', $group->id) }}" data-content="@lang('admin/groups/message.delete.confirm')"
data-title="@lang('general.delete')"
{{ htmlspecialchars($group->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
			</td>
		</tr>
		@endforeach
		@else
		<tr>
			<td colspan="5">@lang('general.no_results')</td>
		</tr>
		@endif
	</tbody>
</table>
</div>


@stop
