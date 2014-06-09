@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
	@if ($category->id)
		@lang('admin/categories/general.update') ::
	@else
		@lang('admin/categories/general.create') ::
	@endif
@parent
@stop

{{-- Page content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
    	<a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="icon-circle-arrow-left icon-white"></i> @lang('general.back')</a>
		<h3>
		@if ($category->id)
			@lang('admin/categories/general.update')
		@else
			@lang('admin/categories/general.create')
		@endif
</h3>
	</div>
</div>

<div class="user-profile">
<div class="row profile">
<div class="col-md-9 bio">

                        <form class="form-horizontal" method="post" action="" autocomplete="off">
						<!-- CSRF Token -->
						<input type="hidden" name="_token" value="{{ csrf_token() }}" />

						<!-- Name -->
						<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="col-md-2 control-label">@lang('admin/categories/general.category_name')</label>
								<div class="col-md-7">
									<input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $category->name) }}" />
									{{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
								</div>
						</div>

						<!-- Form actions -->
						<div class="form-group">
						<label class="col-md-2 control-label"></label>
							<div class="col-md-7">
								<a class="btn btn-link" href="{{ URL::previous() }}">@lang('general.cancel')</a>
								<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
							</div>
						</div>
					</form>
					<br><br><br><br><br>
					</div>

                    <!-- side address column -->
                    <div class="col-md-3 col-xs-12 address pull-right">
						<br /><br />
						<h6>@lang('admin/categories/general.about_asset_categories')</h6>
						<p>@lang('admin/categories/general.about_categories') </p>

                    </div>
</div>
</div>
@stop
