@extends('layouts/setup')

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
        <label for="site_name">
          {{ trans('general.site_name') }}
        </label>
        {{ Form::text('site_name', old('site_name'), array('class' => 'form-control','placeholder' => 'Snipe-IT Asset Management', 'required' => true)) }}

        {!! $errors->first('site_name', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>
    </div>

  <div class="row">

    <!-- Language -->
    <div class="form-group col-lg-6{{$errors->has('default_language') ? ' error' : ''}}">
      <label for="locale">
        {{ trans('admin/settings/general.default_language') }}
      </label>
      {!! Form::locales('locale', old('locale', "en-US"), 'select2') !!}
      {!! $errors->first('locale', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>

    <!-- Currency -->
    <div class="form-group col-lg-6{{$errors->has('default_currency') ? ' error' : ''}}">
      {{ Form::label('default_currency', trans('admin/settings/general.default_currency')) }}
      {{ Form::text('default_currency', old('default_currency'), array('class' => 'form-control','placeholder' => 'USD', 'maxlength'=>'3', 'style'=>'width: 60px;')) }}

      {!! $errors->first('default_currency', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>

  </div>

  <div class="row">

    <div class="form-group col-lg-6">

      <label class="form-control form-control">
        <input type="checkbox" value="1" name="auto_increment_assets">{{trans('admin/settings/general.auto_increment_assets')}}
      </label>

    </div>

    <!-- Multi Company Support -->
    <div class="form-group col-lg-6">
      <label class="form-control form-control">
        <input type="checkbox" value="1" name="full_multiple_companies_support">  {{ trans('admin/settings/general.full_multiple_companies_support_text') }}
      </label>
    </div>


  </div>

  <div class="row">

    <div class="form-group col-lg-6{{ $errors->has('auto_increment_prefix') ? ' error' : '' }}">
      {{ Form::label('auto_increment_prefix', trans('admin/settings/general.auto_increment_prefix')) }}
      {{ Form::text('auto_increment_prefix', old('auto_increment_prefix'), array('class' => 'form-control')) }}

      {!! $errors->first('auto_increment_prefix', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>

    <div class="form-group col-lg-6{{ $errors->has('zerofill_count') ? ' error' : '' }}">
      {{ Form::label('zerofill_count', trans('admin/settings/general.zerofill_count')) }}
      {{ Form::text('zerofill_count', old('zerofill_count', 5), array('class' => 'form-control')) }}

      {!! $errors->first('zerofill_count', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>
  </div>


    <!-- email domain -->
    <div class="row">
      <div class="form-group col-lg-6 required {{ $errors->has('email_domain') ? 'error' : '' }}">
        {{ Form::label('email_domain', trans('general.email_domain')) }}
        {{ Form::text('email_domain', old('email_domain'), array('class' => 'form-control','placeholder' => 'example.com','required' => true)) }}
        <span class="help-block">{{ trans('general.email_domain_help')  }}</span>

        {!! $errors->first('email_domain', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>

      <!-- email format  -->
      <div class="form-group col-lg-6 {{ $errors->has('email_format') ? 'error' : '' }}">
        {{ Form::label('email_format', trans('general.email_format')) }}
        {!! Form::username_format('email_format', old('email_format', 'filastname'), 'select2') !!}
        {!! $errors->first('email_format', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>
    </div>

    <!-- Name -->
    <div class="row">
      <!-- first name -->
      <div class="form-group col-lg-6">
        {{ Form::label('first_name', trans('general.first_name'), 'required') }}
        {{ Form::text('first_name', old('first_name'), array('class' => 'form-control','placeholder' => 'Jane', 'required' => true)) }}
        {!! $errors->first('first_name', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>

      <!-- last name -->
      <div class="form-group col-lg-6 required {{ $errors->has('last_name') ? 'error' : '' }}">
        {{ Form::label('last_name', trans('general.last_name')) }}
        {{ Form::text('last_name', old('last_name'), array('class' => 'form-control','placeholder' => 'Smith', 'required' => true)) }}
        {!! $errors->first('last_name', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>
    </div>

    <div class="row">
      <!-- email-->
      <div class="form-group col-lg-6{{ $errors->has('email') ? 'error' : '' }}">
        {{ Form::label('email', trans('admin/users/table.email')) }}
        {{ Form::email('email', config('mail.from.address'), array('class' => 'form-control','placeholder' => 'you@example.com', 'required' => true)) }}
        {!! $errors->first('email', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>

      <!-- username -->
      <div class="form-group col-lg-6{{  (Helper::checkIfRequired(\App\Models\User::class, 'username')) ? ' required' : '' }} {{ $errors->has('username') ? 'error' : '' }}">
        {{ Form::label('username', trans('admin/users/table.username')) }}
        {{ Form::text('username', old('username'), array('class' => 'form-control','placeholder' => 'jsmith', 'required' => true)) }}
        {!! $errors->first('username', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>
    </div>

    <div class="row">
      <!-- password -->
      <div class="form-group col-lg-6{{  (Helper::checkIfRequired(\App\Models\User::class, 'password')) ? ' required' : '' }} {{ $errors->has('password') ? 'error' : '' }}">
        {{ Form::label('password', trans('admin/users/table.password')) }}
        {{ Form::password('password', array('class' => 'form-control','required' => true)) }}
        {!! $errors->first('password', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>

      <!-- password confirm -->
      <div class="form-group col-lg-6{{  (Helper::checkIfRequired(\App\Models\User::class, 'password')) ? ' required' : '' }} {{ $errors->has('password_confirm') ? 'error' : '' }}">
        {{ Form::label('password_confirmation', trans('admin/users/table.password_confirm')) }}
        {{ Form::password('password_confirmation', array('class' => 'form-control','required' => true)) }}
        {!! $errors->first('password_confirmation', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
      </div>
    </div>

    <!-- Email credentials -->
    <div class="form-group col-lg-12">
      <label class="form-control form-control">
        <input type="checkbox" value="1" name="email_creds">{{ trans('admin/users/general.email_credentials_text') }}
      </label>
    </div>
  </div> <!--/.COL-LG-12-->
@stop

@section('button')
  <button class="btn btn-primary">{{ trans('admin/users/general.next_save_user') }}</button>
</form>
@parent
@stop
