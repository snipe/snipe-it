@extends('backend/layouts/default')

{{-- Web site Title --}}
@section('title')
@lang('admin/groups/titles.create_group') ::
@parent
@stop

{{-- Content --}}
@section('content')


<div class="row header">
    <div class="col-md-12">
			<a href="{{ URL::previous() }}" class="btn btn-flat gray pull-right"><i class="icon-circle-arrow-left icon-white"></i> @lang('general.back')</a>
			<h3>@lang('admin/groups/titles.create_group')</h3>
	</div>
</div>

<div class="row form-wrapper">
<div class="col-md-10 column">

<form class="form-horizontal" method="post" action="" autocomplete="off">
	<!-- CSRF Token -->
	<input type="hidden" name="_token" value="{{ csrf_token() }}" />

			<!-- Name -->
			<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
				<label for="name" class="col-md-2 control-label">@lang('admin/groups/titles.group_name')</label>
					<div class="col-md-6">
						<input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name') }}" />
						{{ $errors->first('name', '<span class="alert-msg"><i class="icon-remove-sign"></i> :message</span>') }}
					</div>
			</div>
			<br><br>
			<br><br>


					@foreach ($permissions as $area => $permissions)
					<fieldset>
						<legend>{{ $area }}</legend>

						@foreach ($permissions as $permission)

						<div class="field-box">
                            <label for="name" class="col-md-2 control-label">{{ $permission['label'] }}</label>
                            <div class="col-md-8">
                                <label class="radio-inline">
                                    <input type="radio" value="1" id="{{ $permission['permission'] }}_allow" name="permissions[{{ $permission['permission'] }}]"{{ (array_get($selectedPermissions, $permission['permission']) === 1 ? ' checked="checked"' : '') }}> @lang('admin/groups/titles.allow')
                                </label>

                                <label class="radio-inline">
                                    <input type="radio" value="0" id="{{ $permission['permission'] }}_deny" name="permissions[{{ $permission['permission'] }}]"{{ ( ! array_get($selectedPermissions, $permission['permission']) ? ' checked="checked"' : '') }}> @lang('admin/groups/titles.deny')
                                </label>
                            </div>
                        </div>
						@endforeach

					</fieldset>
					@endforeach

				<br><br><br><br>


				<!-- Form actions -->
				<div class="form-group">
				<label class="col-md-2 control-label"></label>
					<div class="col-md-7">
						<a class="btn btn-link" href="{{ URL::previous() }}">@lang('general.cancel')</a>
						<button type="submit" class="btn btn-success"><i class="icon-ok icon-white"></i> @lang('general.save')</button>
					</div>
				</div>


</form>

</div>
				</div>
@stop

