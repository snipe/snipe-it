@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/statuslabels/table.title') ::
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
    	<a href="{{ route('create/statuslabel') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('general.create')</a>
		<h3>@lang('admin/statuslabels/table.title')</h3>
	</div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

			<br>
			<!-- checked out assets table -->

			<table id="example">
			<thead>
				<tr role="row">
					<th class="col-md-4">@lang('admin/statuslabels/table.name')</th>
					<th class="col-md-2 actions">@lang('table.actions')</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($statuslabels as $statuslabel)
				<tr>
					<td>{{ $statuslabel->name }}</td>
					<td>
						<a href="{{ route('update/statuslabel', $statuslabel->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
<a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/statuslabel', $statuslabel->id) }}" data-content="@lang('admin/statuslabels/message.delete.confirm')"
				data-title="@lang('general.delete')
				 {{ htmlspecialchars($statuslabel->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

		</div>

	<!-- side address column -->
   <div class="col-md-3 col-xs-12 address pull-right">
		<br /><br />
		<h6>@lang('admin/statuslabels/table.about')</h6>
		<p>@lang('admin/statuslabels/table.info')</p>

	</div>

</div>

@stop





