@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Create a User ::
@parent
@stop

{{-- Page content --}}
@section('content')
<script type="text/javascript">
$( document ).ready(function() {
	$( "#sync" ).click( function() {
		alert("OK");
	});
});
</script>

<div class="page-header">
    <h3>
        Create Users from LDAP

        <div class="pull-right">
            <a href="{{ route('users') }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-circle-left icon-white"></i>  @lang('general.back')</a>

        </div>
    </h3>
</div>
<script type="text/javascript" src="{{ Config::get('app.cdn.default') }}/js/pGenerator.jquery.js"></script>



<form class="form-horizontal" role="form" method="post" action="">
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
				Connect to LDAP and create users.  Passwords will be auto-generated.				
			</p>
			<p>
				LDAP configuration settings can be found in the app/config folder in a file called ldap.php
			</p>

            @if (Config::get('app.lock_passwords'))
                <p>Note: Email notification for users is disabled for this installation.</p>
            @endif

			<!--
			<div class="form-group {{ $errors->has('connection_string') ? 'has-error' : '' }}">
                <label class="col-md-3 control-label" for="connection_string">LDAP Connection String <i class='fa fa-asterisk'></i></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" name="connection_string" id="connection_string" value="" />
                    {{ $errors->first('connection_string', '<br><span class="alert-msg">:message</span>') }}
                </div>
            </div>

			<div class="form-group {{ $errors->has('ldap_username') ? 'has-error' : '' }}">
                <label class="col-md-3 control-label" for="ldap_username">Username <i class='fa fa-asterisk'></i></label>
                <div class="col-md-7">
                    <input class="form-control" type="text" name="ldap_username" id="ldap_username" value="" />
                    {{ $errors->first('ldap_username', '<br><span class="alert-msg">:message</span>') }}
                </div>
            </div>

			<div class="form-group {{ $errors->has('ldap_password') ? 'has-error' : '' }}">
                <label class="col-md-3 control-label" for="ldap_password">Password <i class='fa fa-asterisk'></i></label>
                <div class="col-md-7">
                    <input class="form-control" type="password" name="ldap_password" id="ldap_password" value="" />
                    {{ $errors->first('ldap_password', '<br><span class="alert-msg">:message</span>') }}
                </div>
            </div>
			-->
			
			<!--
            <div class="form-group {{ $errors->first('user_import_csv', 'has-error') }}">
                <label for="first_name" class="col-sm-2 control-label">@lang('admin/users/general.usercsv')</label>
				<div class="col-sm-5">
					<input type="file" name="user_import_csv" id="user_import_csv">
				</div>
            </div>
			-->
            <!-- Has Headers -->
			<!--
			<div class="form-group">
				<div class="col-sm-2 ">
				</div>
				<div class="col-sm-5">
					{{ Form::checkbox('has_headers', '1', Input::old('has_headers')) }} This CSV has a header row
				</div>
			</div>
			-->
			<!-- Email user -->
			<!--
			<div class="form-group">
				<div class="col-sm-2 ">
				</div>
				<div class="col-sm-5">
					{{ Form::checkbox('email_user', '1', Input::old('email_user')) }} Email these users their credentials? (Only possible where email address is included with user data.)
				</div>
			</div>
			-->
			<!-- Activate -->
			<!--
			<div class="form-group">
				<div class="col-sm-2 ">
				</div>
				<div class="col-sm-5">
					{{ Form::checkbox('activate', '1', Input::old('activate')) }} Activate user?
				</div>
			</div>
			-->


        </div>
    </div>

    <!-- Form Actions -->
	<!--
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-4">
            <a class="btn btn-link" href="{{ route('users') }}">@lang('button.cancel')</a>
            <button type="submit" class="btn btn-default">@lang('button.submit')</button>
        </div>
    </div>
	-->
	<div class="form-group">
		<label class="col-md-3 control-label"></label>
			<div class="col-md-7">
				<!--
				<a class="btn btn-link" href="{{ route('users') }}">@lang('button.cancel')</a>
				<button type="reset" class="btn">Reset</button> -->
				<button type="submit" class="btn btn-warning" id="sync">
					<i class="fa fa-refresh icon-white"></i> Synchronize
				</button>

			</div>
		</div>
</form>

@if (Session::get('summary'))
<h3>Synchronization Results</h3>
    <table class="table table-bordered">
        <tr>
            <th>Username</th><th>York ID</th>
            <th>First Name</th><th>Last Name</th>
            <th>Email</th><th>Notes</th>
	</tr>
	<?php
				$summary = Session::get('summary');
				foreach( $summary as $entry ) {
					echo "<tr>";
					echo "<td>" . $entry['username'] . "</td>";
					echo "<td>" . $entry['pycyin'] . "</td>";
					echo "<td>" . $entry['firstname'] . "</td>";
					echo "<td>" . $entry['lastname'] . "</td>";
					echo "<td>" . $entry['mail'] . "</td>";
					echo "<td>" . $entry['note'] . "</td>";
					echo "</tr>";
				}
				?>
				</table>
			
			@endif

@stop
