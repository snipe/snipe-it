@extends('layouts/setup')

{{-- Page title --}}
@section('title')
Create a User ::
@parent
@stop

{{-- Page content --}}
@section('content')

<p> This is the account information you'll use to access the site for the first time. All fields are required. </p>

<form action="{{ route('setup.user.save') }}" method="POST">
  {{ csrf_field() }}

  <div class="col-lg-12" style="padding-top: 20px;">
    <!-- Site Name -->
    <div class="row">
      <div class="form-group col-lg-12 {{ $errors->has('site_name') ? 'error' : '' }}">
        {{ Form::label('site_name', trans('general.site_name')) }}
        {{ Form::text('site_name', Input::old('site_name'), array('class' => 'form-control','placeholder' => 'Snipe-IT Asset Management')) }}

        {!! $errors->first('site_name', '<span class="alert-msg">:message</span>') !!}
      </div>
    </div>

    <!-- email domain -->
    <div class="row">
      <div class="form-group col-lg-6 {{ $errors->has('email_domain') ? 'error' : '' }}">
        {{ Form::label('email_domain', trans('general.email_domain')) }}
        {{ Form::text('email_domain', Input::old('email_domain'), array('class' => 'form-control','placeholder' => 'example.com')) }}
        <span class="help-block">{{ trans('general.email_domain_help')  }}</span>

        {!! $errors->first('email_domain', '<span class="alert-msg">:message</span>') !!}
      </div>

      <!-- email format  -->
      <div class="form-group col-lg-6 {{ $errors->has('email_format') ? 'error' : '' }}">
        {{ Form::label('email_format', trans('general.email_format')) }}
        {!! Form::username_format('email_format', Input::old('email_format', 'filastname'), 'select2') !!}
        {!! $errors->first('email_format', '<span class="alert-msg">:message</span>') !!}
      </div>
    </div>

    <!-- Name -->
    <div class="row">
      <!-- first name -->
      <div class="form-group col-lg-6 {{ $errors->has('first_name') ? 'error' : '' }}">
        {{ Form::label('first_name', trans('general.first_name')) }}
        {{ Form::text('first_name', Input::old('first_name'), array('class' => 'form-control','placeholder' => 'Jane')) }}
        {!! $errors->first('first_name', '<span class="alert-msg">:message</span>') !!}
      </div>

      <!-- last name -->
      <div class="form-group col-lg-6 {{ $errors->has('last_name') ? 'error' : '' }}">
        {{ Form::label('last_name', trans('general.last_name')) }}
        {{ Form::text('last_name', Input::old('last_name'), array('class' => 'form-control','placeholder' => 'Smith')) }}
        {!! $errors->first('last_name', '<span class="alert-msg">:message</span>') !!}
      </div>
    </div>

    <div class="row">
      <!-- email-->
      <div class="form-group col-lg-6 {{ $errors->has('email') ? 'error' : '' }}">
        {{ Form::label('email', trans('admin/users/table.email')) }}
        {{ Form::email('email', config('mail.from.address'), array('class' => 'form-control','placeholder' => 'you@example.com')) }}
        {!! $errors->first('email', '<span class="alert-msg">:message</span>') !!}
      </div>

      <!-- username -->
      <div class="form-group col-lg-6 {{ $errors->has('username') ? 'error' : '' }}">
        {{ Form::label('username', trans('admin/users/table.username')) }}
        {{ Form::text('username', Input::old('username'), array('class' => 'form-control','placeholder' => 'jsmith')) }}
        {!! $errors->first('username', '<span class="alert-msg">:message</span>') !!}
      </div>
    </div>

    <div class="row">
      <!-- password -->
      <div class="form-group col-lg-6 {{ $errors->has('password') ? 'error' : '' }}">
        {{ Form::label('password', trans('admin/users/table.password')) }}
        {{ Form::password('password', array('class' => 'form-control')) }}
        {!! $errors->first('password', '<span class="alert-msg">:message</span>') !!}
      </div>

      <!-- password confirm -->
      <div class="form-group col-lg-6 {{ $errors->has('password_confirm') ? 'error' : '' }}">
        {{ Form::label('password_confirmation', trans('admin/users/table.password_confirm')) }}
        {{ Form::password('password_confirm', array('class' => 'form-control')) }}
        {!! $errors->first('password_confirmation', '<span class="alert-msg">:message</span>') !!}
      </div>
    </div>

    <!-- Email credentials -->
    <div class="form-group col-lg-12">
      <label>Email credentials</label>
      <div class="checkbox">
        <label>
          <input type="checkbox" value="1" name="email_creds">Email my credentials to the email address above
        </label>
      </div>
    </div>
  </div> <!--/.COL-LG-12-->
@stop

@section('button')
  <button class="btn btn-primary">Next: Save User</button>
</form>
@parent
@stop
