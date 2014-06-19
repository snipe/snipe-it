@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Settings ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div id="pad-wrapper" class="user-profile">
                <!-- header -->

                <div class="pull-right">
					 <a href="{{ route('edit/settings') }}" class="btn-flat white"> @lang('button.edit') Settings</a>
				</div>


				<h3 class="name">Settings</h3>


                <div class="row-fluid profile">
                    <!-- bio, new note & orders column -->
                    <div class="col-md-9 bio">
                        <div class="profile-box">
                            <br>
                            <!-- checked out assets table -->

                            <table class="table table-hover">
							<thead>
								<tr>
									<th class="col-md-3">Setting</th>
									<th class="col-md-3"><span class="line"></span>Value</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($settings as $setting)
								<tr>
									<td>Site Name</td>
									<td>{{ $setting->site_name }}  </td>
								</tr>
								<tr>
									<td>@lang('admin/settings/general.display_asset_name')</td>


@if ($setting->display_asset_name === '1')
								<td>Yes</td>
@else
								<td>No</td>
@endif
								</tr>

								<tr>
									<td>Per Page</td>
									<td>{{ $setting->per_page }}  </td>
								</tr>
								<tr>
									<td>Display QR Codes</td>
@if ($setting->qr_code === '1')
								<td>Yes</td>
@else
								<td>No</td>
@endif
								</tr>
<tr>
									<td>QR Code Text</td>
									<td>{{ $setting->qr_text }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>

                        </div>
                    </div>

                    <!-- side address column -->
                    <div class="col-md-3 address pull-right">
						<br /><br />

						<p>These settings let you customize certain aspects of your installation. </p>

                    </div>
@stop