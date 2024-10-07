@extends('layouts/basic')


{{-- Page content --}}
@section('content')

    <form role="form" id="login-form" action="{{ url('/login') }}" method="POST" autocomplete="{{ (config('auth.login_autocomplete') === true) ? 'on' : 'off'  }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />


        <!-- this is a hack to prevent Chrome from trying to autocomplete fields -->
        <input type="text" name="prevent_autofill" id="prevent_autofill" value="" style="display:none;" aria-hidden="true">
        <input type="password" name="password_fake" id="password_fake" value="" style="display:none;" aria-hidden="true">

        <div class="container">
            <div class="row">

                <div class="col-md-4 col-md-offset-4">

                    @if (($snipeSettings->google_login=='1') && ($snipeSettings->google_client_id!='') && ($snipeSettings->google_client_secret!=''))

                        <br><br>
                        <a href="{{ route('google.redirect')  }}" class="btn btn-block btn-social btn-google btn-lg">
                            <i class="fa-brands fa-google"></i>
                            {{ trans('auth/general.google_login') }}
                        </a>

                        <div class="separator">{{ strtoupper(trans('general.or')) }}</div>
                    @endif


                    <div class="box login-box">
                        <div class="box-header with-border">
                            <h1 class="box-title"> {{ trans('auth/general.login_prompt')  }}</h1>
                        </div>


                        <div class="login-box-body">
                            <div class="row">

                                @if ($snipeSettings->login_note)
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            {!!  Helper::parseEscapedMarkedown($snipeSettings->login_note)  !!}
                                        </div>
                                    </div>
                                @endif

                                <!-- Notifications -->
                                @include('notifications')

                                @if (!config('app.require_saml'))
                                <div class="col-md-12">
                                    <!-- CSRF Token -->


                                    <fieldset>

                                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                            <label for="username">
                                                <x-icon type="user" />
                                                {{ trans('admin/users/table.username')  }}
                                            </label>
                                            <input class="form-control" placeholder="{{ trans('admin/users/table.username')  }}" name="username" type="text" id="username" autocomplete="{{ (config('auth.login_autocomplete') === true) ? 'on' : 'off'  }}" autofocus>
                                            {!! $errors->first('username', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                        </div>
                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label for="password">
                                                <x-icon type="password" />
                                                {{ trans('admin/users/table.password')  }}
                                            </label>
                                            <input class="form-control" placeholder="{{ trans('admin/users/table.password')  }}" name="password" type="password" id="password" autocomplete="{{ (config('auth.login_autocomplete') === true) ? 'on' : 'off'  }}">
                                            {!! $errors->first('password', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                                        </div>
                                        <div class="form-group">
                                            <label class="form-control">
                                                <input name="remember" type="checkbox" value="1"> {{ trans('auth/general.remember_me')  }}
                                            </label>
                                        </div>
                                    </fieldset>
                                </div> <!-- end col-md-12 -->
                                @endif
                            </div> <!-- end row -->

                            @if (!config('app.require_saml') && $snipeSettings->saml_enabled)
                            <div class="row">
                                <div class="text-right col-md-12">
                                    <a href="{{ route('saml.login')  }}">{{ trans('auth/general.saml_login')  }}</a>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="box-footer">
                            @if (config('app.require_saml'))
                                <a class="btn btn-primary btn-block" href="{{ route('saml.login')  }}">{{ trans('auth/general.saml_login')  }}</a>
                            @else
                                {{-- <button class="btn btn-primary btn-block">{{ trans('auth/general.login')  }}</button> --}}
                                <button class="g-recaptcha btn btn-primary btn-block" 
                                data-sitekey="{{ config('recaptcha.site_key') }}"
                                data-callback='onSubmit'
                                data-action='submit'>{{ trans('auth/general.login')  }}</button>
                            @endif
                            @if (config('services.azure.client_id'))
                                <a href="{{ route('login.azure') }}" class="btn btn-primary" style="margin-top: 3px; width: 100%; background-color: white;color: black; outline: gray; border: solid 1px #c8c3c3; display:flex; justify-content:center; align-items:center">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="25" height="25" viewBox="0 0 48 48" style="margin-inline:2px">
                                        <path fill="#ff5722" d="M6 6H22V22H6z" transform="rotate(-180 14 14)"></path><path fill="#4caf50" d="M26 6H42V22H26z" transform="rotate(-180 34 14)"></path><path fill="#ffc107" d="M26 26H42V42H26z" transform="rotate(-180 34 34)"></path><path fill="#03a9f4" d="M6 26H22V42H6z" transform="rotate(-180 14 34)"></path>
                                        </svg>{{ trans('auth/general.azure_login')  }}
                                </a>
                            @endif
                            @if ($snipeSettings->custom_forgot_pass_url)
                                <div class="col-md-12 text-right" style="padding-top: 15px;">
                                    <a href="{{ $snipeSettings->custom_forgot_pass_url  }}" rel="noopener">{{ trans('auth/general.forgot_password')  }}</a>
                                </div>
                            @elseif (!config('app.require_saml'))
                                <div class="col-md-12 text-right" style="padding-top: 15px;">
                                    <a href="{{ route('password.request')  }}">{{ trans('auth/general.forgot_password')  }}</a>
                                </div>
                            @endif

                        </div>

                    </div> <!-- end login box -->


                </div> <!-- col-md-4 -->

            </div> <!-- end row -->
        </div> <!-- end container -->
    </form>

@stop

@push('js')
@if (config('recaptcha.secret_key'))
<script src="https://www.google.com/recaptcha/api.js"></script>
@endif
<script>
function onSubmit(token) {
    document.getElementById("login-form").submit();
}
</script>
@endpush