@extends('layouts/basic')


{{-- Page content --}}
@section('content')

    <form role="form" action="{{ url('/login') }}" method="POST" autocomplete="off">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        <div class="container">
            <div class="row">

                <div class="col-md-4 col-md-offset-4">

                    <div class="box login-box">
                        <div class="box-header">
                            <h3 class="box-title"> {{ trans('auth/general.login_prompt')  }}</h3>
                        </div>


                        <div class="login-box-body">
                            <div class="row">


                                <!-- Notifications -->
                                @include('notifications')

                                <div class="col-md-12">
                                    <!-- CSRF Token -->


                                    <fieldset>
                                        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                            <input class="form-control" placeholder="{{ trans('admin/users/table.username')  }}" name="username" type="text" autofocus>
                                            {!! $errors->first('username', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                                        </div>
                                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <input class="form-control" placeholder="{{ trans('admin/users/table.password')  }}" name="password" type="password" autocomplete="off">
                                            {!! $errors->first('password', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                                        </div>
                                        <div class="checkbox">
                                            <label>
                                                <input name="remember" type="checkbox" value="Remember Me">{{ trans('auth/general.remember_me')  }}
                                            </label>
                                        </div>
                                    </fieldset>
                                </div> <!-- end col-md-12 -->

                            </div> <!-- end row -->
                        </div>
                        <div class="box-footer">
                            <button class="btn btn-lg btn-primary btn-block">{{ trans('auth/general.login')  }}</button>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="padding-top: 10px;">
                            <a href="{{ config('app.url') }}/password/reset">{{ trans('auth/general.forgot_password')  }}</a>
                        </div>
                    </div> <!-- end login box -->

                </div> <!-- col-md-4 -->

            </div> <!-- end row -->
        </div> <!-- end container -->
    </form>

@stop
