@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@if ($category->id)
	Category Update ::
@else
	Create Category ::
	@endif
@parent
@stop

{{-- Page content --}}
@section('content')
<div id="pad-wrapper" class="user-profile">
                <!-- header -->
				<h3 class="name">Asset Categories
				<div class="pull-right">
					<a href="{{ route('categories') }}" class="btn-flat gray"><i class="icon-circle-arrow-left icon-white"></i> Back</a>
				</div>
		</h3>


                <div class="row-fluid profile">
                    <!-- bio, new note & orders column -->
                    <div class="span9 bio">
                        <div class="profile-box">
                            <br>
                        <form class="form-horizontal" method="post" action="" autocomplete="off">
						<!-- CSRF Token -->
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />

						<!-- Category Title -->
						<div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
							<label class="control-label" for="name">Category Name</label>
							<div class="controls">
								<input type="text" name="name" id="name" value="{{ Input::old('name', $category->name) }}" />
								{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
							</div>
						</div>

						<!-- Form actions -->
						<div class="form-group">
							<div class="controls">
								<a class="btn btn-link" href="{{ route('categories') }}">@lang('general.cancel')</a>
								<button type="submit" class="btn-flat success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
							</div>
						</div>
					</form>


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
