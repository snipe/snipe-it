@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Asset Categories ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
    	<a href="{{ route('create/category') }}" class="btn btn-success pull-right"><i class="icon-plus-sign icon-white"></i> Create New</a>
		<h3>Asset Categories</h3>
	</div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

		<table id="example">
		<thead>
			<tr role="row">
				<th class="col-md-7">@lang('admin/categories/table.title')</th>
				<th class="col-md-2">@lang('table.actions')</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($categories as $category)
			<tr>
				<td>{{ $category->name }}</td>
				<td>
				<a href="{{ route('update/category', $category->id) }}" class="btn btn-warning"><i class="icon-pencil icon-white"></i></a>
<a data-html="false" class="btn delete-asset btn-danger" data-toggle="modal" href="{{ route('delete/category', $category->id) }}" data-content="Are you sure you wish to delete this category?" data-title="Delete {{ htmlspecialchars($category->name) }}?" onClick="return false;"><i class="icon-trash icon-white"></i></a>


				</td>
			</tr>
			@endforeach
		</tbody>
		</table>


	</div>


<!-- side address column -->
<div class="col-md-3 col-xs-12 address pull-right">
	<br /><br />
	<h6>About Asset Categories</h6>
	<p>Asset categories help you organize your assets. Some
	example categories might be &quot;Desktops&quot;, &quot;Laptops&quot;, &quot;Mobile Phones&quot;, &quot;Tablets&quot;,
	and so on, but you can use asset categories any way that makes sense for you.  </p>

</div>
</div>
</div>
@stop