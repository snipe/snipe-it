@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{ trans('general.editprofile') }}
@stop

{{-- Account page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">
  {{ Form::open(['method' => 'POST', 'files' => true, 'class' => 'form-horizontal', 'autocomplete' => 'off']) }}
  <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="box box-default">
      <div class="box-body">
        <!-- First Name -->
        <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
          <label for="first_name" class="col-md-3 control-label">{{ trans('general.first_name') }}
          </label>
          <div class="col-md-8 required">
            <input class="form-control" type="text" name="first_name" id="first_name" value="{{ Input::old('first_name', $user->first_name) }}" />
            {!! $errors->first('first_name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
          </div>
        </div>

        <!-- Last Name -->
        <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
          <label for="last_name" class="col-md-3 control-label">
            {{ trans('general.last_name') }}
          </label>
          <div class="col-md-8 required">
            <input class="form-control" type="text" name="last_name" id="last_name" value="{{ Input::old('last_name', $user->last_name) }}" />
            {!! $errors->first('last_name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
          </div>
        </div>


        @can('self.edit_location')
        <!-- Location -->
        @include ('partials.forms.edit.location-profile-select', ['translated_name' => trans('general.location')])
        @endcan


        <!-- Language -->
        <div class="form-group {{ $errors->has('locale') ? 'has-error' : '' }}">
          <label class="col-md-3 control-label" for="locale">{{ trans('general.language') }}</label>
          <div class="col-md-9">

            @if (!config('app.lock_passwords'))
              {!! Form::locales('locale', Input::old('locale', $user->locale), 'select2') !!}
              {!! $errors->first('locale', '<span class="alert-msg">:message</span>') !!}
            @else
              <p class="help-block">{{ trans('general.feature_disabled') }}</p>
            @endif

          </div>
        </div>

        <!-- Phone -->
        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
          <label class="col-md-3 control-label" for="phone">{{ trans('admin/users/table.phone') }}</label>
          <div class="col-md-4">
            <input class="form-control" type="text" name="phone" id="phone" value="{{ Input::old('phone', $user->phone) }}" />
            {!! $errors->first('phone', '<span class="alert-msg">:message</span>') !!}
          </div>
        </div>



        <!-- Website URL -->
        <div class="form-group {{ $errors->has('website') ? ' has-error' : '' }}">
          <label for="website" class="col-md-3 control-label">{{ trans('general.website') }}</label>
          <div class="col-md-8">
            <input class="form-control" type="text" name="website" id="website" value="{{ Input::old('website', $user->website) }}" />
            {!! $errors->first('website', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
          </div>
        </div>

        <!-- Gravatar Email -->
        <div class="form-group {{ $errors->has('gravatar') ? ' has-error' : '' }}">
          <label for="gravatar" class="col-md-3 control-label">{{ trans('general.gravatar_email') }}
            <small>(Private)</small>
          </label>
          <div class="col-md-8">
            <input class="form-control" type="text" name="gravatar" id="gravatar" value="{{ Input::old('gravatar', $user->gravatar) }}" />
            {!! $errors->first('gravatar', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
            <p>
              <img src="//secure.gravatar.com/avatar/{{ md5(strtolower(trim($user->gravatar))) }}" width="30" height="30" />
              <a href="http://gravatar.com"><small>Change your avatar at Gravatar.com</small></a>.
            </p>
          </div>
        </div>

        <!-- Avatar -->
        @if ($user->avatar)
          <div class="form-group {{ $errors->has('avatar_delete') ? 'has-error' : '' }}">
            <label class="col-md-3 control-label" for="avatar_delete">{{ trans('general.avatar_delete') }}</label>
            <div class="col-md-8">
              {{ Form::checkbox('avatar_delete') }}
              <img src="{{ url('/') }}/uploads/avatars/{{ $user->avatar }}" class="avatar img-circle">
              {!! $errors->first('avatar_delete', '<span class="alert-msg">:message</span>') !!}
            </div>
          </div>
        @endif

        <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
          <label class="col-md-3 control-label" for="avatar">{{ trans('general.image_upload') }}</label>
          <div class="col-md-5">
            <label class="btn btn-default">
              {{ trans('button.select_file')  }}
              <input type="file" name="avatar" accept="image/gif,image/jpeg,image/png,image/svg" hidden>
            </label>
            <p class="help-block">{{ trans('general.image_filetypes_help') }}</p>
            {!! $errors->first('avatar', '<span class="alert-msg">:message</span>') !!}
          </div>
        </div>



        <!-- Two factor opt in -->
        @if ($snipeSettings->two_factor_enabled=='1')
        <div class="form-group {{ $errors->has('avatar') ? 'has-error' : '' }}">
          <div class="col-md-7 col-md-offset-3">
            @can('self.two_factor')
              <label for="avatar">{{ Form::checkbox('two_factor_optin', '1', Input::old('two_factor_optin', $user->two_factor_optin),array('class' => 'minimal')) }}
            @else
                <label for="avatar">{{ Form::checkbox('two_factor_optin', '1', Input::old('two_factor_optin', $user->two_factor_optin),['class' => 'disabled minimal', 'disabled' => 'disabled']) }}
            @endcan

            {{ trans('admin/settings/general.two_factor_enabled_text') }}</label>
            @can('self.two_factor')
              <p class="help-block">{{ trans('admin/settings/general.two_factor_enabled_warning') }}</p>
            @else
              <p class="help-block">{{ trans('admin/settings/general.two_factor_enabled_edit_not_allowed') }}</p>
            @endcan
            @if (config('app.lock_passwords'))
              <p class="help-block">{{ trans('general.feature_disabled') }}</p>
            @endif
          </div>
        </div>
        @endif


      </div> <!-- .box-body -->
      <div class="box-footer text-right">
        <a class="btn btn-link" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
      </div>
    </div> <!-- .box-default -->
    {{ Form::close() }}
  </div> <!-- .col-md-9 -->
</div> <!-- .row-->

@stop
