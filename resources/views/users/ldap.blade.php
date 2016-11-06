@extends('layouts/default')

{{-- Page title --}}
@section('title')
LDAP User Sync
@parent
@stop


@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
  {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

<div class="row">
<div class="col-md-9">


@if ($snipeSettings->ldap_enabled == 0)
    {{ trans('admin/users/message.ldap_not_configured') }}
@else


    <form class="form-horizontal" role="form" method="post" action="" id="ldap-form">
    <!-- CSRF Token -->
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <div class="box box-default">
      <div class="box-body">

        <div class="form-group {{ $errors->has('location_id') ? 'has-error' : '' }}">
          <label class="col-md-2 control-label" for="location_id">{{ trans('admin/users/table.location') }}
              </label>
          <div class="col-md-6">
            {{ Form::select('location_id', $location_list , Input::old('location_id'), array('class'=>'select2', 'style'=>'width:350px')) }}

              {!! $errors->first('location_id', '<span class="alert-msg">:message</span>') !!}
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-warning" id="sync">
                <i id="sync-button-icon" class="fa fa-refresh icon-white"></i> <span id="sync-button-text">Synchronize</span>
            </button>
          </div>

        </div>

      </div>
    </div>
    </form>
  </div>
  <div class="col-md-3">
    <p>
        {{ trans('admin/users/general.ldap_config_text') }}
    </p>
  </div>
</div>
<div class="row">
<div class="col-md-12">

    @if (Session::get('summary'))

    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Synchronization Results</h3>
      </div><!-- /.box-header -->
      <div class="box-body">

        <table class="table table-bordered">
            <tr>
                <th>Username</th><th>Employee Number</th>
                <th>First Name</th><th>Last Name</th>
                <th>Email</th><th>Notes</th>
            </tr>

            @foreach (Session::get('summary') as $entry)
              <tr {!! ($entry['status']=='success') ? 'class="success"' : 'class="danger"' !!}>
                <td>{{ $entry['username'] }}</td>
                <td>{{ $entry['employee_number'] }}</td>
                <td>{{ $entry['firstname'] }}</td>
                <td>{{ $entry['lastname'] }}</td>
                <td>{{ $entry['email'] }}</td>
                <td>
                  @if ($entry['status']=='success')
                    <i class="fa fa-check"></i> {!! $entry['note'] !!}
                  @else
                    <span class="alert-msg">{!! $entry['note'] !!}</span>
                  @endif

                  </td>
                </tr>

            @endforeach
        </table>

      </div>
    </div>


    @endif
@endif
</div>
</div>

@section('moar_scripts')

<script type="text/javascript">
    $(document).ready(function () {
        $("#sync").click(function () {
            $("#sync").removeClass("btn-warning");
            $("#sync").addClass("btn-success");
            $("#sync-button-icon").addClass("fa-spin");
            $("#sync-button-text").html(" Processing...");
        });
    });
</script>

@stop
@stop
