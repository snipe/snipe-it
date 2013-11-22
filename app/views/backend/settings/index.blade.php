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
				<h3 class="name">Settings
						<div class="pull-right">
							<!-- <a href="{{ route('edit/settings') }}" class="btn-flat white"> @lang('button.edit') Settings</a> -->
						</div>
		</h3>


                <div class="row-fluid profile">
                    <!-- bio, new note & orders column -->
                    <div class="span9 bio">
                        <div class="profile-box">
                            <br>
                            <!-- checked out assets table -->

                            <table class="table table-hover">
							<thead>
								<tr>
									<th class="span4">Setting</th>
									<th class="span2"><span class="line"></span>Value</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($settings as $setting)
								<tr>
									<td>{{ $setting->option_label }}</td>
									<td>{{ $setting->option_value }}  </td>

								</tr>
								@endforeach
							</tbody>
						</table>

                        </div>
                    </div>

                    <!-- side address column -->
                    <div class="span3 address pull-right">
						<br /><br />

						<p>These settings let you customize certain aspects of your installation. </p>

                    </div>
@stop