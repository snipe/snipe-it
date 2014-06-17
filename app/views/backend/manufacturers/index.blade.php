@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('admin/manufacturers/table.asset_manufacturers') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
    	<a href="{{ route('create/manufacturer') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i>  @lang('general.create')</a>
		<h3>@lang('admin/manufacturers/table.asset_manufacturers')</h3>
	</div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">


<table id="example">
	<thead>
		<tr role="row">
			<th class="col-md-7">@lang('admin/manufacturers/table.name')</th>
			<th class="col-md-2 actions">@lang('table.actions')</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($manufacturers as $manufacturer)
		<tr>
			<td>{{ $manufacturer->name }}</td>
			<td>

				<a href="{{ route('update/manufacturer', $manufacturer->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
				<a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/manufacturer', $manufacturer->id) }}" data-content="@lang('admin/manufacturers/message.delete.confirm')"
				data-title="@lang('general.delete')
				 {{ htmlspecialchars($manufacturer->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>


			</td>
		</tr>
		@endforeach
	</tbody>
</table>
</div>

	<!-- side address column -->
   <div class="col-md-3 col-xs-12 address pull-right">
		<br /><br />
		<h6>Have Some Haiku</h6>
		<p>The Staples truck came.<br>
		Left thirteen cardboard boxes.<br>
		Honey stained maple.</p>

		<p>----------</p>

		<p>I'm sorry, there's – um -<br>
		insufficient – what's-it-called?<br>
		The term eludes me...</p>

	</div>

</div>


@stop
