@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@if ($statuslabel->id)
		Update Status Label ::
	@else
		Create New Status Label ::
	@endif
@parent
@stop

{{-- Page content --}}
@section('content')
<div id="pad-wrapper" class="user-profile">
                <!-- header -->
                <div class="pull-right">
					<a href="{{ route('statuslabels') }}" class="btn-flat gray"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
				</div>

				<h3 class="name">
					@if ($statuslabel->id)
						Update Status Label
					@else
						Create New Status Label
					@endif
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

									<div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
										<label class="control-label" for="name">Status Label</label>
										<div class="controls">
											<input class="span9" type="text" name="name" id="name" value="{{ Input::old('name', $statuslabel->name) }}" />
											{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
										</div>
									</div>

									<!-- Form actions -->
									<div class="control-group">
										<div class="controls">
											<a class="btn btn-link" href="{{ route('statuslabels') }}">@lang('general.cancel')</a>
											<button type="submit" class="btn-flat success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
										</div>
									</div>
							</form>

					 	</div>
</div>

                    <!-- side address column -->
                    <div class="span3 address pull-right">
					<br /><br />
						<h6>About Status Labels</h6>
						<p>Status labels are used to describe the various reasons why an asset <strong><em>cannot</em></strong> be deployed. </p>

						<p>It could be broken, out for diagnostics, out for
						repair, lost or stolen, etc. Status labels allow your team to show the progression.</p>

                    </div>


@stop