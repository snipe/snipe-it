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

<script type="text/javascript" src="{{ asset('/assets/js/pGenerator.jquery.js') }}"></script>

@if (Setting::getSettings()->ldap_enabled == 0)
    @Lang('admin/users/message.ldap_not_configured')
@else

    <p>
        @Lang('admin/users/general.ldap_text')
    </p>
    <p>
        @Lang('admin/users/general.ldap_config_text')
    </p>
    <form class="form-horizontal" role="form" method="post" action="" id="ldap-form">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        <div class="form-group {{ $errors->has('location_id') ? 'has-error' : '' }}">
                <label class="col-md-3 control-label" for="location_id">@lang('admin/users/table.location')
                    </label>
                <div class="col-md-7">
                    {{ Form::select('location_id', $location_list, array('class'=>'select2', 'style'=>'width:350px')) }}
                    {{ $errors->first('location_id', '<br><span class="alert-msg">:message</span>') }}
                </div>
            </div>
        
        <button type="submit" class="btn btn-warning" id="sync">
            <i id="sync-button-icon" class="fa fa-refresh icon-white"></i> <span id="sync-button-text">Synchronize</span>
        </button>
        

    </form>
    @if (Session::get('summary'))
    <h3>Synchronization Results</h3>
    <table class="table table-bordered">
        <tr>
            <th>Username</th><th>Employee Number</th>
            <th>First Name</th><th>Last Name</th>
            <th>Email</th><th>Notes</th>
        </tr>
        <?php
        $summary = Session::get('summary');
        foreach ($summary as $entry) {
            echo "<tr>";
            echo "<td>" . $entry['username'] . "</td>";
            echo "<td>" . $entry['employee_number'] . "</td>";
            echo "<td>" . $entry['firstname'] . "</td>";
            echo "<td>" . $entry['lastname'] . "</td>";
            echo "<td>" . $entry['email'] . "</td>";
            echo "<td>" . $entry['note'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    @endif
@endif

@stop
