@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
		Update Settings ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div id="pad-wrapper" class="user-profile">
                <!-- header -->

                <div class="pull-right">
					<a href="{{ URL::previous() }}" class="btn-flat gray"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
				</div>

				<h3 class="name">Update Settings</h3>


                <div class="row-fluid profile">
                    <!-- bio, new note & orders column -->
                    <div class="col-md-9 bio">
                        <div class="profile-box">
                            <br>
                            <!-- checked out assets table -->

                            <form class="form-horizontal" method="post" action="" autocomplete="off">
								<!-- CSRF Token -->
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />

								@foreach ($settings as $setting)

									<div class="form-group {{ $errors->has('site_name') ? 'error' : '' }}">
										<label class="control-label" for="site_name">Site Name</label>
										<div class="controls">
											<input class="col-md-9" type="text" name="site_name" id="site_name" value="{{ Input::old('site_name', $setting->site_name) }}" />
											{{ $errors->first('site_name', '<span class="help-inline">:message</span>') }}
										</div>
									</div>
									<div class="form-group {{ $errors->has('per_page') ? 'error' : '' }}">
										<label class="control-label" for="per_page">Results Per Page</label>
										<div class="controls">
											<input class="col-md-1" type="text" name="per_page" id="per_page" value="{{ Input::old('per_page', $setting->per_page) }}" />
											{{ $errors->first('per_page', '<span class="help-inline">:message</span>') }}
										</div>
									</div>

									<div class="form-group {{ $errors->has('qr_code') ? 'error' : '' }}">
										<label class="control-label" for="qr_code">Display QR Codes</label>
										<div class="controls">
									@if ($is_gd_installed)
											<input class="col-md-1" type="checkbox" name="qr_code" id="qr_code" value="1" {{ $setting->qr_code === '1' ? 'checked' : '' }} />
									@else
											<span class="help-inline">
												PHP Image Processing and GD plugin is NOT installed.
												<br>
												You must install php-gd to display QR codes, see <a href="http://www.php.net/manual/en/image.installation.php">install instructions</a>.
											</span>
									@endif
											{{ $errors->first('qr_code', '<span class="help-inline">:message</span>') }}
											</div>
									</div>

									<div class="form-group {{ $errors->has('qr_text') ? 'error' : '' }}">
										<label class="control-label" for="qr_text">QR Code Text</label>
										<div class="controls">
									@if ($setting->qr_code === '1')
											<input class="col-md-9" type="text" name="qr_text" id="qr_text" value="{{ Input::old('qr_text', $setting->qr_text) }}" />
									@else
											<span class="help-inline">
												Enable QR Codes first to set this
											</span>
									@endif
											{{ $errors->first('qr_text', '<span class="help-inline">:message</span>') }}
											</div>
									</div>



								@endforeach

								<!-- Form actions -->
									<div class="form-group">
										<div class="controls">
											<a class="btn btn-link" href="{{ URL::previous() }}">@lang('general.cancel')</a>
											<button type="submit" class="btn-flat success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
										</div>
								</div>
							</form>

					 	</div>
</div>

                    <!-- side address column -->
                    <div class="col-md-3 address pull-right">
					<br /><br />
						<p>These settings let you customize certain aspects of your installation. </p>

                    </div>


@stop