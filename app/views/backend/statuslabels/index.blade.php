@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Status Labels
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
    	<a href="{{ route('create/statuslabel') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('general.create')</a>
		<h3>Status Labels</h3>
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
<a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/statuslabel', $statuslabel->id) }}" data-content="Are you sure you wish to delete this status label?" data-title="Delete {{ htmlspecialchars($statuslabel->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

		</div>

	<!-- side address column -->
   <div class="col-md-3 col-xs-12 address pull-right">
		<br /><br />
		<h6>About Status Labels</h6>
		<p>Status labels are used to describe the various reasons why an asset <strong><em>cannot</em></strong> be deployed. </p>

		<p>It could be broken, out for diagnostics, out for
		repair, lost or stolen, etc. Status labels allow your team to show the progression.</p>

	</div>

</div>

@stop





