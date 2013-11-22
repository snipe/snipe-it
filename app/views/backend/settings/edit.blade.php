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
				<h3 class="name">Update Settings
				<div class="pull-right">
					<a href="{{ route('app') }}" class="btn-flat gray"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
				</div>

				</h3>


                <div class="row-fluid profile">
                    <!-- bio, new note & orders column -->
                    <div class="span9 bio">
                        <div class="profile-box">
                            <br>
                            <!-- checked out assets table -->

                            <form class="form-horizontal" method="post" action="" autocomplete="off">
								<!-- CSRF Token -->
								<input type="hidden" name="_token" value="{{ csrf_token() }}" />
								@foreach ($settings as $setting)
									<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
										<label class="control-label" for="option_value">{{ $setting->option_label }}</label>
										<div class="controls">
											<input class="span9" type="text" name="option_value['{{ $setting->option_name }}']" id="option_value" value="{{ Input::old('option_value', $setting->option_value) }}" />
											{{ $errors->first('option_value', '<span class="help-inline">:message</span>') }}
										</div>
									</div>


								@endforeach

								<!-- Form actions -->
									<div class="control-group">
										<div class="controls">
											<a class="btn btn-link" href="{{ route('app') }}">@lang('general.cancel')</a>
											<button type="submit" class="btn-flat success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
										</div>
								</div>
							</form>

					 	</div>
</div>

                    <!-- side address column -->
                    <div class="span3 address pull-right">
					<br /><br />
						<p>These settings let you customize certain aspects of your installation. </p>

                    </div>


@stop