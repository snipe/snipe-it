@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
Create a User ::
@parent
@stop

{{-- Page content --}}
@section('content')

<script type="text/javascript">
    $(document).ready(function () {
        $("#sync").click(function () {
            $("#sync").removeClass("btn-warning");
            $("#sync-button-icon").addClass("fa-spin");
            $("#sync-button-text").html(" Processing...");
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


<p>
    Connect to LDAP and create users.  Passwords will be auto-generated.				
</p>
<p>
    LDAP configuration settings can be found in the app/config folder in a file called ldap.php
</p>
<form class="form-horizontal" role="form" method="post" action="" id="ldap-form">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <button type="submit" class="btn btn-warning" id="sync">
        <i id="sync-button-icon" class="fa fa-refresh icon-white"></i> <span id="sync-button-text">Synchronize</span>
    </button>
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
    foreach ($summary as $entry) {
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
