@extends('layouts/setup')

{{-- Page title --}}
@section('title')
{{ trans('admin/setup/general.pre_flight_check') }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

    <p>{{ trans('admin/setup/general.pre_flight_check_text') }}</p>


      <table class="table">
        <thead>
        <tr>
          <th class="col-lg-2">{{ trans('general.settings') }}</th>
          <th class="col-lg-1">{{ trans('general.valid') }}</th>
          <th class="col-lg-9">{{ trans('general.notes') }}</th>
        </tr>
      </thead>
      <tbody>
        <tr{!! ($start_settings['url_valid']) ? ' class="success"' : ' class="danger"' !!}>
          <td>URL</td>
          <td>
            @if ($start_settings['url_valid'])
              <i class="fa fa-check preflight-success"></i>
            @else
              <i class="fa fa-times preflight-error"></i>
            @endif

          </td>
          <td>
            @if ($start_settings['url_valid'])
              {{ trans('admin/setup/general.url_valid_text') }}
            @else
              {{ trans('admin/setup/general.url_notvalid_text1') }} {{ $start_settings['url_config'] }}{{ trans('admin/setup/general.url_notvalid_text2') }} {{ $start_settings['real_url'] }}
              {{ trans('admin/setup/general.url_notvalid_text3') }}
            @endif
          </td>
        </tr>
        <tr{!! ($start_settings['db_conn']===true) ? ' class="success"' : ' class="danger"' !!}>
          <td>{{ trans('admin/setup/general.database') }}</td>
          <td>
            @if ($start_settings['db_conn']===true)
              <i class="fa fa-check preflight-success"></i>
            @else
              <i class="fa fa-times preflight-error"></i>
            @endif
          </td>
          <td>
              @if ($start_settings['db_conn']===true)
                {{ trans('admin/setup/general.database_connected_text') }}<code>{{ $start_settings['db_name'] }}</code>
              @else
                {{ trans('admin/setup/general.database_notconnected_text') }}<code>{{ $start_settings['db_error'] }}</code>
              @endif
          </td>
        </tr>
        <tr{!! (!$start_settings['env_exposed']) ? ' class="success"' : ' class="danger"' !!}>
          <td>{{ trans('admin/setup/general.config_file') }}</td>
          <td>
            @if (!$start_settings['env_exposed'])
              <i class="fa fa-check preflight-success"></i>
            @else
              <i class="fa fa-times preflight-error"></i>
            @endif
          </td>
          <td>
              @if (!$start_settings['env_exposed'])
                Sweet. It does not look like your <code>.env</code> file is exposed to the outside world. (You should double check this in a browser though. You do not ever want anyone able to see that file. Ever. Ever ever.) <a href="../../.env">Click here to check now</a> (This should return a file not found or forbidden error.)		
              @else
                Please make sure your <code>.env</code>. You do not ever want anyone able to see that file. Ever. Ever ever.  <a href="../../.env">Click here to check now</a> (This should return a file not found or forbidden error.)
              @endif
          </td>
        </tr>

        <tr{!! ($start_settings['prod']) ? ' class="success"' : ' class="warning"' !!}>
          <td>{{ trans('general.environment') }}</td>
          <td>
            @if ($start_settings['prod'])
              <i class="fa fa-check preflight-success"></i>
            @else
              <i class="fa fa-times preflight-error"></i>
            @endif
          </td>
          <td>
              @if ($start_settings['prod'])
                Your app is set to production mode. Rock on!
              @else
                Your app is set <code>{{ $start_settings['env'] }}</code> instead of <code>production</code> mode. If you're not planning on developing on Snipe-IT, please update your <code>APP_ENV</code> settings in your  <code>.env</code> file to <code>production</code>.
              @endif
          </td>
        </tr>

        <tr{!! (!$start_settings['owner_is_admin']) ? ' class="success"' : ' class="danger"' !!}>
          <td>{{ trans('admin/setup/general.file_owner') }}</td>
          <td>
            @if (!$start_settings['owner_is_admin'])
              <i class="fa fa-check preflight-success"></i>
            @else
              <i class="fa fa-times preflight-error"></i>
            @endif
          </td>
          <td>
              @if (!$start_settings['owner_is_admin'])
                Your app files are owned by <code>{{ $start_settings['owner'] }}</code>. That doesn't look like a default root/admin account. Nice!
              @else
                It looks like your files are owned by <code>{{ $start_settings['owner'] }}</code>, which might be a root/admin account. It's never a good idea to run a website with escalated priveliges.
              @endif
          </td>
        </tr>

        <tr{!! (!$start_settings['writable']) ? ' class="danger"' : ' class="success"' !!}>
          <td>{{ trans('general.permissions') }}</td>
          <td>
            @if ($start_settings['writable'])
              <i class="fa fa-check preflight-success"></i>
            @else
              <i class="fa fa-times preflight-error"></i>
            @endif
          </td>
          <td>
              @if ($start_settings['writable'])
                {{ trans('admin/setup/general.permisions_writable_text') }}
              @else
                {{ trans('admin/setup/general.permisions_notwritable_text') }}
              @endif
          </td>
        </tr>

        <tr{!! ($start_settings['debug_exposed']) ? ' class="danger"' : ' class="success"' !!}>
          <td>Debug</td>
          <td>
            @if (!$start_settings['debug_exposed'])
              <i class="fa fa-check preflight-success"></i>
            @else
              <i class="fa fa-times preflight-error"></i>
            @endif
          </td>
          <td>
              @if (!$start_settings['debug_exposed'])
                Awesomesauce. Debug is either turned off, or you're running this in a non-production environment. (Don't forget to turn it off when you're ready to go live.)
              @else
                Yikes! You should turn off debug mode unless you encounter any issues. Please update your <code>APP_DEBUG</code> settings in your  <code>.env</code> file
              @endif
          </td>
        </tr>

        <tr{!! ($start_settings['gd']) ? ' class="success"' : ' class="warning"' !!}>
          <td>{{ trans('admin/setup/general.image_library') }}</td>
          <td>
            @if ($start_settings['gd'])
              <i class="fa fa-check preflight-success"></i>
            @else
              <i class="fa fa-times preflight-warning"></i>
            @endif
          </td>
          <td>
              @if ($start_settings['gd'])
                {{ trans('admin/setup/general.image_library_correct_text') }}
              @else
                 {{ trans('admin/setup/general.image_library_incorrect_text') }}
              @endif
          </td>
        </tr>
        <tr id="mailrow">
          <td>Email</td>
          <td id="mailtesticon">
          </td>
          <td id="mailtestresult">
             <button class="btn btn-default" id="mailtest">{{ trans('button.test_email') }}</button>
              <span id="mailtestresult"></span>
          </td>
        </tr>

      </tbody>
      </table>



        @section('button')
          <form action="{{ route('setup.migrate') }}" method="GET">
            <button class="btn btn-primary">{{ trans('general.next') }}: {{ trans('admin/setup/general.create_database_tables') }}</button>
          </form>
        @parent
        @stop



@section('moar_scripts')
    <script type="text/javascript">
        $(document).ready(function () {

        $("#mailtest").click(function(){

              $("#mailtestresult").html('<i class="fa fa-spinner fa-spin"></i> Sending Email');

              $.ajax({url: "{{ route('setup.mailtest') }}", success: function(result){
                  if (result=='success') {
                    $("#mailrow").addClass('success');
                    $("#mailtesticon").html('<i class="fa fa-check preflight-success"></i>');
                    $("#mailtestresult").html('No errors on this end! Check your <code>{{ config('mail.from.address') }}</code> email account for a test email.');
                  } else {
                    $("#mailrow").addClass('danger');
                    $("#mailtesticon").html('<i class="fa fa-check preflight-error"></i>');
                    $("#mailtestresult").html('Something went wrong. Your email was not sent. Check your mail settings in your <code>.env</code> file.');

                  }


              },
              error: function (result) {
                $("#mailrow").addClass('danger');
                $("#mailtesticon").html('<i class="fa fa-check preflight-error"></i>');
                $("#mailtestresult").html('Something went wrong. The server returned an error. Check your mail settings in your <code>.env</code> file, and check your <code>storage/logs</code> for additional information..');
              }


            });

        });
     });
    </script>
@stop
@stop
