@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Asset Depreciations ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div id="pad-wrapper" class="user-profile">
                <!-- header -->
				<h3 class="name">Asset Depreciations
				<div class="pull-right">
					<a href="{{ route('create/depreciations') }}" class="btn-flat success"><i class="icon-plus-sign icon-white"></i>  Create New</a>
				</div>
		</h3>


                <div class="row-fluid profile">
                    <!-- bio, new note & orders column -->
                    <div class="col-md-9 bio">
                        <div class="profile-box">
                            <br>
                            <!-- checked out assets table -->

                            <table id="example">
						<thead>
							<tr role="row">
								<th class="col-md-4">@lang('admin/depreciations/table.title')</th>
								<th class="col-md-2">@lang('admin/depreciations/table.term')</th>
								<th class="col-md-3">@lang('table.actions')</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($depreciations as $depreciation)
							<tr>
								<td>{{ $depreciation->name }}</td>
								<td>{{ $depreciation->months }} @lang('admin/depreciations/table.months') </td>
								<td>
									<a href="{{ route('update/depreciations', $depreciation->id) }}" class="btn-flat white">@lang('button.edit')</a>
									<a data-html="false" class="btn-flat danger delete-asset" data-toggle="modal" href="{{ route('delete/depreciations', $depreciation->id) }}" data-content="Are you sure you wish to delete this depreciation class?" data-title="Delete {{ htmlspecialchars($depreciation->name) }}?" onClick="return false;">@lang('button.delete')</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>


                        </div>
                    </div>

                    <!-- side address column -->
                    <div class="col-md-3 address pull-right">
						<br /><br />
						<h6>About Asset Depreciations</h6>
						<p>You can set up asset depreciations to depreciate assets based on straight-line depreciation.  </p>

                    </div>
@stop