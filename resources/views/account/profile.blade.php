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
            <input class="form-control" type="text" name="first_name" id="first_name" value="{{ old('first_name', $user->first_name) }}" />
            {!! $errors->first('first_name', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
          </div>
        </div>

        <!-- Last Name -->
        <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
          <label for="last_name" class="col-md-3 control-label">
            {{ trans('general.last_name') }}
          </label>
          <div class="col-md-8 required">
            <input class="form-control" type="text" name="last_name" id="last_name" value="{{ old('last_name', $user->last_name) }}" />
            {!! $errors->first('last_name', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
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
              {!! Form::locales('locale', old('locale', $user->locale), 'select2') !!}
              {!! $errors->first('locale', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
            @else
              <p class="help-block">{{ trans('general.feature_disabled') }}</p>
            @endif

          </div>
        </div>

        @if ($snipeSettings->allow_user_skin=='1')
        <!-- Skin -->
        <div class="form-group {{ $errors->has('skin') ? 'error' : '' }}">
          <label for="website" class="col-md-3 control-label">{{ Form::label('skin', trans('general.skin')) }}</label>
          <div class="col-md-8">
            {!! Form::user_skin('skin', old('skin', $user->skin), 'select2') !!}
            {!! $errors->first('skin', '<span class="alert-msg">:message</span>') !!}
          </div>
        </div>
        @endif

        <!-- Phone -->
        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
          <label class="col-md-3 control-label" for="phone">{{ trans('admin/users/table.phone') }}</label>
          <div class="col-md-4">
            <input class="form-control" type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" />
            {!! $errors->first('phone', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
          </div>
        </div>

        <!-- Website URL -->
        <div class="form-group {{ $errors->has('website') ? ' has-error' : '' }}">
          <label for="website" class="col-md-3 control-label">{{ trans('general.website') }}</label>
          <div class="col-md-8">
            <input class="form-control" type="text" name="website" id="website" value="{{ old('website', $user->website) }}" />
            {!! $errors->first('website', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
          </div>
        </div>

        <!-- Gravatar Email -->
        <div class="form-group {{ $errors->has('gravatar') ? ' has-error' : '' }}">
          <label for="gravatar" class="col-md-3 control-label">{{ trans('general.gravatar_email') }}
            <small>(Private)</small>
          </label>
          <div class="col-md-8">
            <input class="form-control" type="text" name="gravatar" id="gravatar" value="{{ old('gravatar', $user->gravatar) }}" />
            {!! $errors->first('gravatar', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
            <p>
              <img src="//secure.gravatar.com/avatar/{{ md5(strtolower(trim($user->gravatar))) }}" width="30" height="30" alt="{{ $user->present()->fullName() }} avatar image">
              {!! trans('general.gravatar_url') !!}
            </p>
          </div>
        </div>

        <!-- Avatar -->

        @if ($user->avatar)
          <div class="form-group {{ $errors->has('image_delete') ? 'has-error' : '' }}">
            <label class="col-md-3 control-label" for="avatar_delete">{{ trans('general.image_delete') }}</label>
            <div class="col-md-9">
              <label for="avatar_delete">
                {{ Form::checkbox('avatar_delete', '1', old('avatar_delete'), array('class' => 'minimal')) }}
              </label>
              <br>
              <img src="{{ url('/') }}/uploads/avatars/{{  $user->avatar }}" alt="{{ $user->present()->fullName() }} avatar image">
              {!! $errors->first('avatar_delete', '<span class="alert-msg" aria-hidden="true"><br>:message</span>') !!}
            </div>
          </div>
        @endif


        @include ('partials.forms.edit.image-upload', ['fieldname' => 'avatar'])



        <!-- Two factor opt in -->
        @if ($snipeSettings->two_factor_enabled=='1')
        <div class="form-group {{ $errors->has('two_factor_optin') ? 'has-error' : '' }}">
          <div class="col-md-7 col-md-offset-3">
            @can('self.two_factor')
              <label for="two_factor_optin">{{ Form::checkbox('two_factor_optin', '1', Request::old('two_factor_optin', $user->two_factor_optin),array('class' => 'minimal')) }}
            @else
                <label for="avatar">{{ Form::checkbox('two_factor_optin', '1', Request::old('two_factor_optin', $user->two_factor_optin),['class' => 'disabled minimal', 'disabled' => 'disabled']) }}
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
      <div class="text-right box-footer">
        <a class="btn btn-link" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
        <button type="submit" class="btn btn-primary"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
      </div>
    </div> <!-- .box-default -->
    {{ Form::close() }}
  </div> <!-- .col-md-9 -->
</div> <!-- .row-->

@stop
