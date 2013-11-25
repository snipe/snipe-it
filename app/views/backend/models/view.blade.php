@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
View Model {{ $model->model_tag }} ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div id="pad-wrapper" class="user-profile">
                <!-- header -->
				<h3 class="name">History for {{ $model->name }}
					<div class="btn-group pull-right">
						<button class="btn glow">Actions</button>
						<button class="btn glow dropdown-toggle" data-toggle="dropdown">
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu">
							<li><a href="{{ route('update/model', $model->id) }}">Edit Asset</a></li>
						</ul>
					</div>
				</h3>


                <div class="row-fluid profile">
                    <!-- bio, new note & orders column -->
                    <div class="span9 bio">
                        <div class="profile-box">
                            <br>
                            <!-- checked out models table -->
							@if (count($model->assets) > 0)
                           <table id="example">
							<thead>
								<tr role="row">
                                        <th class="span3">Name</th>
                                        <th class="span3">Asset Tag</th>
                                         <th class="span3">User</th>
                                    </tr>
                                </thead>
                                <tbody>

										@foreach ($model->assets as $modelassets)
									<tr>
										<td>{{ $modelassets->name }}</td>
										<td>{{ $modelassets->asset_tag }}</td>
										<td>
										@if ($modelassets->assigned_to)
											<a href="{{ route('view/user', $modelassets->assigned_to) }}">
											{{ $modelassets->assigned_to }}
											</a>
										@else

										@endif
										</td>

									</tr>
									@endforeach


                                </tbody>
                            </table>

                            @else
                            <div class="col-md-6">
								<div class="alert alert-info alert-block">
									<i class="icon-info-sign"></i>
									There are no results for your query.
								</div>
							</div>
                            @endif

                        </div>
                    </div>

                    <!-- side address column -->
                    <div class="span3 address pull-right">

                    <h6><br>More Info:</h6>
                       		<ul>

								@if ($model->purchase_date)
								<li>Purchase Date: {{ $model->purchase_date }} </li>
								@endif
								@if ($model->purchase_cost)
								<li>Purchase Cost: ${{ number_format($model->purchase_cost) }} </li>
								@endif
								@if ($model->order_number)
								<li>Order #: {{ $model->order_number }} </li>
								@endif
								@if ($model->warranty_months)
								<li>Warranty: {{ $model->warranty_months }} months</li>
								<li>Expires: {{ $model->warrantee_expires() }}</li>
								@endif

								@if ($model->depreciation)
								<li>Depreciation: {{ $model->depreciation->name }} ({{ $model->depreciation->months }} months)</li>
								@endif

							</ul>



							<ul>
								<li><br><br />This model is not currently assigned to anyone. You may check it into inventory
								using the button below.</li>
							</ul>

                    </div>
@stop