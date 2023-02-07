@extends('layouts/default')

{{-- Page title --}}
@section('title')
    Update LDAP/AD Settings
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-default"> {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

    <style>
        .checkbox label {
            padding-right: 40px;
        }
    </style>




    @livewire('ldap-settings-form')


@stop

@push('js')
    <script nonce="{{ csrf_token() }}">

        /**
         * Check to see if is_ad is checked, if not disable the ad_domain field
         */
        $(function() {
            if( $('#is_ad').prop('checked') === false) {
                $('#ad_domain').prop('disabled', 'disabled');
            } else {
                //$('#ldap_server').prop('disabled', 'disabled');
            }
        });

        /**
         * Toggle the server info based on the is_ad checkbox
         */
        $('#is_ad').on('ifClicked', function(){
            $('#ad_domain').toggleDisabled();
            //$('#ldap_server').toggleDisabled();
        });


        /**
         * Test the LDAP connection settings
         */
        $("#ldaptest").click(function () {
            $("#ldapad_test_results").removeClass('hidden text-success text-danger');
            $("#ldapad_test_results").html('');
            $("#ldapad_test_results").html('<i class="fas fa-spinner spin"></i> {{ trans('admin/settings/message.ldap.testing') }}');
            $.ajax({
                url: '{{ route('api.settings.ldaptest') }}',
                type: 'GET',
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data: {},
                dataType: 'json',

                success: function (data) {
                    $("#ldapad_test_results").html('');
                    let html = buildLdapTestResults(data)
                    $("#ldapad_test_results").html(
                        html
                    );
                },

                error: function (data) {
                    $("#ldapad_test_results").html('');
                    $("#ldapad_test_results").addClass('text-danger');
                    let errorIcon = '<i class="fas fa-exclamation-triangle text-danger"></i>' + ' ';
                    if (data.status == 500) {
                        $('#ldapad_test_results').html(errorIcon + '{{ trans('admin/settings/message.ldap.500') }}');
                    } else if (data.status == 400) {
                        let errorMessage = '';
                        if( typeof data.responseJSON.user_sync !== 'undefined') {
                            errorMessage =  data.responseJSON.user_sync.message;
                        }
                        if( typeof data.responseJSON.message !== 'undefined') {
                            errorMessage =  data.responseJSON.message;
                        }
                        $('#ldapad_test_results').html(errorIcon + errorMessage);
                    } else {
                        $('#ldapad_test_results').html('{{ trans('admin/settings/message.ldap.error') }}');
                       // $('#ldapad_test_results').html(errorIcon + data.responseText.message);
                    }
                }


            });
        });

        /**
         * Build the results html table
         */
        function buildLdapTestResults(results) {
            let html = '<ul style="list-style: none;padding-left: 5px;">'
            html += '<li class="text-success"><i class="fas fa-check" aria-hidden="true"></i> ' + results.login.message + ' </li>'
            html += '<li class="text-success"><i class="fas fa-check" aria-hidden="true"></i> ' + results.bind.message + ' </li>'
            html += '</ul>'
            html += '<div>{{ trans('admin/settings/message.ldap.sync_success') }}</div>'
            html += '<table class="table table-bordered table-condensed" style="background-color: #fff">'
            html += buildLdapResultsTableHeader()
            html += buildLdapResultsTableBody(results.user_sync.users)
            html += '<table>'
            return html;
        }

        function buildLdapResultsTableHeader(user)
        {
            var keys = [
                '{{ trans('admin/settings/general.employee_number') }}',
                '{{ trans('mail.username') }}',
                '{{ trans('general.first_name') }}',
                '{{ trans('general.last_name') }}',
                '{{ trans('general.email') }}'
            ]
            let header = '<thead><tr>'
            for (var i in keys) {
                header += '<th>' + keys[i] + '</th>'
            }
            header += "</tr></thead>"
            return header;
        }

        function buildLdapResultsTableBody(users)
        {
            let body = '<tbody>'
            for (var i in users) {
                body += '<tr><td>' + users[i].employee_number + '</td><td>' + users[i].username + '</td><td>' + users[i].firstname + '</td><td>' + users[i].lastname + '</td><td>' + users[i].email + '</td></tr>'
            }
            body += "</tbody>"
            return body;
        }

        $("#ldaptestlogin").click(function(){
            $("#ldaptestloginrow").removeClass('text-success');
            $("#ldaptestloginrow").removeClass('text-danger');
            $("#ldaptestloginstatus").removeClass('text-danger');
            $("#ldaptestloginstatus").html('');
            $("#ldaptestloginicon").html('<i class="fas fa-spinner spin"></i> {{ trans('admin/settings/message.ldap.testing_authentication') }}');
            $.ajax({
                url: '{{ route('api.settings.ldaptestlogin') }}',
                type: 'POST',
                headers: {
                    "X-Requested-With": 'XMLHttpRequest',
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'ldaptest_user': $('#ldaptest_user').val(),
                    'ldaptest_password': $('#ldaptest_password').val()
                },

                dataType: 'json',

                success: function (data) {
                    $("#ldaptestloginicon").html('');
                    $("#ldaptestloginrow").addClass('text-success');
                    $("#ldaptestloginstatus").addClass('text-success');
                    $("#ldaptestloginstatus").html('<i class="fas fa-check text-success"></i> {{ trans('admin/settings/message.ldap.authentication_success') }}');
                },

                error: function (data) {

                    if (data.responseJSON) {
                        var errors = data.responseJSON.message;
                    } else {
                        var errors;
                    }

                    var error_text = '';

                    $("#ldaptestloginicon").html('');
                    $("#ldaptestloginstatus").addClass('text-danger');
                    $("#ldaptestloginicon").html('<i class="fas fa-exclamation-triangle text-danger"></i>');

                    if (data.status == 500) {
                        $('#ldaptestloginstatus').html('{{ trans('admin/settings/message.ldap.500') }}');
                    } else if (data.status == 400) {

                        if (typeof errors !='string') {

                            for (i = 0; i < errors.length; i++) {
                                if (errors[i]) {
                                    error_text += '<li>Error: ' + errors[i];
                                }

                            }

                        } else {
                            error_text = errors;
                        }

                        $('#ldaptestloginstatus').html(error_text);

                    } else {
                        $('#ldaptestloginstatus').html(data.responseText.message);
                    }
                }




            });
        });
    </script>
@endpush
