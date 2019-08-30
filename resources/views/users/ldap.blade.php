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
      {{csrf_field()}}
      <div class="box box-default">
        <div class="box-body">
          <!-- location_id-->
          <div class="form-group {{ $errors->has('location_id') ? 'has-error' : '' }}">
              <!-- Location -->
              @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])
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

@if (Session::get('summary'))
<div class="row">
  <div class="col-md-12">

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

  </div>
</div>
@endif

@stop

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
