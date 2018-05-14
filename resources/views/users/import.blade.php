@extends('layouts/default')

{{-- Page title --}}
@section('title')
Create a User
@parent
@stop

@section('header_right')
<a href="{{ route('users.index') }}" class="btn btn-default"> {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')

<link rel="stylesheet" type="text/css" href="{{ asset('css/lib/jquery.fileupload.css') }}">
<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="">
            <div class="box box-default">
                <div class="box-body">

                    @if (config('app.lock_passwords'))
                        <p class="alert alert-warning">CSV uploads are disabled on the demo.</p>
                    @endif

                    <!-- CSRF Token -->
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                    @if (Session::get('message'))
                    <p class="alert-danger">
                        You have an error in your CSV file:<br />
                        {{ Session::get('message') }}
                    </p>
                    @endif

                    <p>
                        Upload a CSV file with one or more users.  Passwords will be auto-generated.  The CSV should have the <strong>first</strong> fields as:
                    </p>

                    <p>
                        <strong>firstName,lastName, username, email, location_id, phone, jobtitle, employee_num, company_id</strong>.
                    </p>

                    <p>
                        Any additional fields to the right of those fields will be ignored. Email is optional, however users will not be able to recover their passwords or receive EULAs if you do not provide an email address. If you wish to include a company association, you must reference the ID number of an existing company - companies will not be created on the fly.
                    </p>




                    <div class="form-group {!! $errors->first('user_import_csv', 'has-error') !!}">
                        <label for="first_name" class="col-sm-3 control-label">{{ trans('admin/users/general.usercsv') }}</label>
                        <div class="col-sm-5">
                            <span class="btn btn-info fileinput-button">
                                    <span>Select Import File...</span>
                                        @if (config('app.lock_passwords'))
                                            <input id="fileupload" type="file" name="user_import_csv" accept="text/csv" disabled="disabled" class="disabled">
                                        @else
                                            <input id="fileupload" type="file" name="user_import_csv" accept="text/csv">
                                        @endif

                                    </span>

                        </div>
                    </div>

                    <!-- Has Headers -->
                    <div class="form-group">
                        <div class="col-sm-2 ">
                        </div>
                        <div class="col-sm-5">
                            {{ Form::checkbox('has_headers', '1', Input::old('has_headers')) }} This CSV has a header row
                        </div>
                    </div>

                    <!-- Email user -->
                    <div class="form-group">
                        <div class="col-sm-2">
                        </div>
                        <div class="col-sm-10">
                            {{ Form::checkbox('email_user', '1', Input::old('email_user')) }} Email these users their credentials? (Only possible where email address is included with user data.)
                        </div>
                    </div>

                    <!-- Activate -->
                    <div class="form-group">
                        <div class="col-sm-2 ">
                        </div>
                        <div class="col-sm-5">
                            {{ Form::checkbox('activate', '1', Input::old('activate')) }} Activate user?
                        </div>
                    </div>
                </div> <!--/box-body-->
                <!-- Form Actions -->
                <div class="box-footer text-right">

                    @if (config('app.lock_passwords'))
                    <button type="submit" class="btn btn-success disabled" disabled="disabled">{{ trans('button.submit') }}</button>
                    @else
                        <button type="submit" class="btn btn-success">{{ trans('button.submit') }}</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

@stop
