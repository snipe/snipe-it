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
                <div class="btn-group pull-right">
					<button class="btn glow">Actions</button>
					<button class="btn glow dropdown-toggle" data-toggle="dropdown">
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
						<li><a href="{{ route('update/model', $model->id) }}">Edit Asset</a></li>
					</ul>
				</div>

				<h3 class="name">History for {{ $model->name }} </h3>


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
                                        <th class="span2">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

									@foreach ($model->assets as $modelassets)
									<tr>
										<td><a href="{{ route('view/asset', $modelassets->id) }}">{{ $modelassets->name }}</a></td>
										<td><a href="{{ route('view/asset', $modelassets->id) }}">{{ $modelassets->asset_tag }}</a></td>
										<td>
										@if ($modelassets->assigneduser)
										<a href="{{ route('view/user', $modelassets->assigned_to) }}">
										{{ $modelassets->assigneduser->fullName() }}
										</a>
										@endif
										</td>
										<td>
										@if ($modelassets->assigned_to != 0)
											<a href="{{ route('checkin/asset', $modelassets->id) }}" class="btn-flat info">Checkin</a>
										@else
											<a href="{{ route('checkout/asset', $modelassets->id) }}" class="btn-flat success">Checkout</a>
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


								@if ($model->manufacturer)
								<li>Manufacturer: {{ $model->manufacturer->name }}</li>
								@endif

								@if ($model->modelno)
								<li>Model No.: {{ $model->modelno }}</li>
								@endif

								@if ($model->depreciation)
								<li>Depreciation: {{ $model->depreciation->name }} ({{ $model->depreciation->months }} months)</li>
								@endif

							</ul>



							<ul>
								<li><br><br /></li>
							</ul>

                    </div>
@stop