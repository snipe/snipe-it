@extends('layouts/setup')
{{ trans('admin/users/table.createuser') }}
@section('title')
{{ trans('admin/users/general.create_user') }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<p>{{ trans('admin/users/general.create_user_page_explanation') }}</p>

<form action="{{ route('setup.user.save') }}" method="POST">
  {{ csrf_field() }}

  <div class="col-lg-12" style="padding-top: 20px;">

    <!-- Site Name -->
    <div class="row">
      <div class="form-group col-lg-12 required {{ $errors->has('site_name') ? 'error' : '' }}">
        {{ Form::label('site_name', trans('general.site_name')) }}
        {{ Form::text('site_name', Request::old('site_name'), array('class' => 'form-control','placeholder' => 'Snipe-IT Asset Management')) }}

        {!! $errors->first('site_name', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>
    </div>

  <div class="row">

    <!-- Language -->
    <div class="form-group col-lg-6{{  (Helper::checkIfRequired(\App\Models\User::class, 'default_language')) ? ' required' : '' }} {{$errors->has('default_language') ? 'error' : ''}}">
      {{ Form::label('locale', trans('admin/settings/general.default_language')) }}
      {!! Form::locales('locale', Request::old('locale', "en"), 'select2') !!}

      {!! $errors->first('locale', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>

    <!-- Currency -->
    <div class="form-group col-lg-6{{  (Helper::checkIfRequired(\App\Models\Setting::class, 'default_currency')) ? ' required' : '' }} {{$errors->has('default_currency') ? 'error' : ''}}">
      {{ Form::label('default_currency', trans('admin/settings/general.default_currency')) }}
      {{ Form::text('default_currency', Request::old('default_currency'), array('class' => 'form-control','placeholder' => 'USD', 'maxlength'=>'3', 'style'=>'width: 60px;')) }}

      {!! $errors->first('default_currency', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>

  </div>

  <div class="row">

    <div class="form-group col-lg-6">
      <label>{{trans('admin/settings/general.auto_increment_assets')}}</label>
      <div class="checkbox">
        <label>
          <input type="checkbox" value="1" name="auto_increment_assets">{{trans('admin/settings/general.auto_increment_assets')}}
        </label>
      </div>
    </div>

    <!-- Multi Company Support -->
    <div class="form-group col-lg-6">
            {{ Form::label('full_multiple_companies_support', trans('admin/settings/general.full_multiple_companies_support_text')) }}
          <div class="checkbox">
            <label>
              <input type="checkbox" value="1" name="full_multiple_companies_support">  {{ trans('admin/settings/general.full_multiple_companies_support_text') }}
            </label>
          </div>
        </div>


  </div>

  <div class="row">

    <div class="form-group col-lg-6{{  (Helper::checkIfRequired(\App\Models\User::class, 'auto_increment_prefix')) ? ' required' : '' }} {{ $errors->has('auto_increment_prefix') ? 'error' : '' }}">
      {{ Form::label('auto_increment_prefix', trans('admin/settings/general.auto_increment_prefix')) }}
      {{ Form::text('auto_increment_prefix', Request::old('auto_increment_prefix'), array('class' => 'form-control')) }}

      {!! $errors->first('auto_increment_prefix', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>

    <div class="form-group col-lg-6{{  (Helper::checkIfRequired(\App\Models\User::class, 'zerofill_count')) ? ' required' : '' }} {{ $errors->has('zerofill_count') ? 'error' : '' }}">
      {{ Form::label('zerofill_count', trans('admin/settings/general.zerofill_count')) }}
      {{ Form::text('zerofill_count', Request::old('zerofill_count', 5), array('class' => 'form-control')) }}

      {!! $errors->first('zerofill_count', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>
  </div>


    <!-- email domain -->
    <div class="row">
      <div class="form-group col-lg-6 required {{ $errors->has('email_domain') ? 'error' : '' }}">
        {{ Form::label('email_domain', trans('general.email_domain')) }}
        {{ Form::text('email_domain', Request::old('email_domain'), array('class' => 'form-control','placeholder' => 'example.com')) }}
        <span class="help-block">{{ trans('general.email_domain_help')  }}</span>

        {!! $errors->first('email_domain', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>

      <!-- email format  -->
      <div class="form-group col-lg-6{{  (Helper::checkIfRequired(\App\Models\User::class, 'email_format')) ? ' required' : '' }} {{ $errors->has('email_format') ? 'error' : '' }}">
        {{ Form::label('email_format', trans('general.email_format')) }}
        {!! Form::username_format('email_format', old('email_format', 'filastname'), 'select2') !!}
        {!! $errors->first('email_format', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>
    </div>

    <!-- Name -->
    <div class="row">
      <!-- first name -->
      <div class="form-group col-lg-6{{  (Helper::checkIfRequired(\App\Models\User::class, 'first_name')) ? ' required' : '' }} {{ $errors->has('first_name') ? 'error' : '' }}">
        {{ Form::label('first_name', trans('general.first_name')) }}
        {{ Form::text('first_name', old('first_name'), array('class' => 'form-control','placeholder' => 'Jane')) }}
        {!! $errors->first('first_name', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>

      <!-- last name -->
      <div class="form-group col-lg-6 required {{ $errors->has('last_name') ? 'error' : '' }}">
        {{ Form::label('last_name', trans('general.last_name')) }}
        {{ Form::text('last_name', old('last_name'), array('class' => 'form-control','placeholder' => 'Smith')) }}
        {!! $errors->first('last_name', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>
    </div>

    <div class="row">
      <!-- email-->
      <div class="form-group col-lg-6{{  (Helper::checkIfRequired(\App\Models\User::class, 'email')) ? ' required' : '' }} {{ $errors->has('email') ? 'error' : '' }}">
        {{ Form::label('email', trans('admin/users/table.email')) }}
        {{ Form::email('email', config('mail.from.address'), array('class' => 'form-control','placeholder' => 'you@example.com')) }}
        {!! $errors->first('email', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>

      <!-- username -->
      <div class="form-group col-lg-6{{  (Helper::checkIfRequired(\App\Models\User::class, 'username')) ? ' required' : '' }} {{ $errors->has('username') ? 'error' : '' }}">
        {{ Form::label('username', trans('admin/users/table.username')) }}
        {{ Form::text('username', old('username'), array('class' => 'form-control','placeholder' => 'jsmith')) }}
        {!! $errors->first('username', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>
    </div>

    <div class="row">
      <!-- password -->
      <div class="form-group col-lg-6{{  (Helper::checkIfRequired(\App\Models\User::class, 'password')) ? ' required' : '' }} {{ $errors->has('password') ? 'error' : '' }}">
        {{ Form::label('password', trans('admin/users/table.password')) }}
        {{ Form::password('password', array('class' => 'form-control')) }}
        {!! $errors->first('password', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>

      <!-- password confirm -->
      <div class="form-group col-lg-6{{  (Helper::checkIfRequired(\App\Models\User::class, 'password')) ? ' required' : '' }} {{ $errors->has('password_confirm') ? 'error' : '' }}">
        {{ Form::label('password_confirmation', trans('admin/users/table.password_confirm')) }}
        {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
        {!! $errors->first('password_confirmation', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>
    </div>

    <!-- Email credentials -->
    <div class="form-group col-lg-12">
      <label>{{ trans('admin/users/general.email_credentials') }}</label>
      <div class="checkbox">
        <label>
          <input type="checkbox" value="1" name="email_creds">{{ trans('admin/users/general.email_credentials_text') }}
        </label>
      </div>
    </div>
  </div> <!--/.COL-LG-12-->
@stop

@section('button')
  <button class="btn btn-primary">{{ trans('admin/users/general.next_save_user') }}</button>
</form>
@parent
@stop
