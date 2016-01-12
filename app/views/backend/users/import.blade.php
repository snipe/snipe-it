@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Create a User ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="page-header">
    <h3>
        Import Users

        <div class="pull-right">
            <a href="{{ route('users') }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-circle-left icon-white"></i>  @lang('general.back')</a>

        </div>
    </h3>
</div>

<script type="text/javascript" src="{{ asset('/assets/js/pGenerator.jquery.js') }}"></script>

<form class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <!-- Tabs Content -->
    <div class="tab-content">
        <!-- General tab -->
        <div class="tab-pane active" id="tab-general">
        <br>
			@if (Session::get('message'))
			<p class="alert-danger">
				You have an error in your CSV file:<br />
				{{ Session::get('message') }}
			</p>
			@endif

			<p>
				Upload a CSV file with one or more users.  Passwords will be auto-generated.  The CSV should have the <strong>first</strong> fields as: </p>

        <p><strong>firstName,lastName, username, email, location_id, phone, jobtitle, employee_num</strong>. </p>

        <p>Any additional fields to the right of those fields will be ignored. Email is optional, however users will not be able to recover their passwords or receive EULAs if you do not provide an email address.
			</p>

            @if (Config::get('app.lock_passwords'))
                <p>Note: Email notification for users is disabled for this installation.</p>
            @endif

            <div class="form-group {{ $errors->first('user_import_csv', 'has-error') }}">
                <label for="first_name" class="col-sm-2 control-label">@lang('admin/users/general.usercsv')</label>
				<div class="col-sm-5">
					<input type="file" name="user_import_csv" id="user_import_csv">
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
				<div class="col-sm-2 ">
				</div>
				<div class="col-sm-5">
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



        </div>
    </div>

    <!-- Form Actions -->
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
            <a class="btn btn-link" href="{{ route('users') }}">@lang('button.cancel')</a>
            <button type="submit" class="btn btn-default">@lang('button.submit')</button>
        </div>
    </div>

</form>

<script>
$(document).ready(function(){

    $('#generate-password').pGenerator({
        'bind': 'click',
        'passwordElement': '#password',
        'displayElement': '#password-display',
        'passwordLength': 10,
        'uppercase': true,
        'lowercase': true,
        'numbers':   true,
        'specialChars': false,

    });
});

</script>
@stop
