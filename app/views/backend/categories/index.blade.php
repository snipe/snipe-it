@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Asset Categories ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div id="pad-wrapper" class="user-profile">
                <!-- header -->
				<h3 class="name">Asset Categories
				<div class="pull-right">
					<a href="{{ route('create/category') }}" class="btn-flat success"><i class="icon-plus-sign icon-white"></i>  Create New</a>
				</div>
		</h3>


                <div class="row-fluid profile">
                    <!-- bio, new note & orders column -->
                    <div class="span9 bio">
                        <div class="profile-box">
                            <br>
                            <!-- checked out assets table -->

                        <table id="example">
						<thead>
							<tr role="row">
								<th class="span6">@lang('admin/categories/table.title')</th>
								<th class="span3">@lang('table.actions')</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($categories as $category)
							<tr>
								<td>{{ $category->name }}</td>
								<td>
									<a href="{{ route('update/category', $category->id) }}" class="btn-flat white"> @lang('button.edit')</a>
									<a class="btn-flat danger delete-asset" data-toggle="modal" href="{{ route('delete/category', $category->id) }}" data-content="Are you sure you wish to delete the  {{ $category->name }} category?" data-title="Delete this category?" onClick="return false;">@lang('button.delete')</a>
								</td>
							</tr>
							@endforeach
						</tbody>
						</table>


                        </div>
                    </div>

                    <!-- side address column -->
                    <div class="span3 address pull-right">
						<br /><br />
						<h6>About Asset Categories</h6>
						<p>Asset categories help you organize your assets. Some
						example categories might be &quot;Desktops&quot;, &quot;Laptops&quot;, &quot;Mobile Phones&quot;, &quot;Tablets&quot;,
						and so on, but you can use asset categories any way that makes sense for you.  </p>

                    </div>
@stop