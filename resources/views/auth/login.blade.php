@extends('layouts/basic')


{{-- Page content --}}
@section('content')
    <div class="container">
        <div class="row">



            <div class="col-md-4 col-md-offset-4">
              <form role="form" action="{{ url('/login') }}" method="POST">

                <div class="box login-box">
                  <div class="box-header">
                    <h3 class="box-title"> Please Login</h3>
                  </div>


                    <div class="login-box-body">
                      <div class="row">


                          <!-- Notifications -->
                          @include('notifications')

                          <div class="col-md-12">
                          <!-- CSRF Token -->
                          <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <fieldset>
                              <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                                {!! $errors->first('username', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                              </div>
                              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                  <input class="form-control" placeholder="Password" name="password" type="password">
                                  {!! $errors->first('password', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                              </div>
                              <div class="checkbox">
                                  <label>
                                      <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                  </label>
                              </div>
                            </fieldset>
                          </div>

                      </div>
                    </div>
                    <div class="box-footer">
                      <button class="btn btn-lg btn-primary btn-block">Login</button>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center" style="padding-top: 10px;">
                        Local user: <code>admin</code> / <code>password</code>  <br>LDAP user: <code>einstein</code> / <code>password</code> 
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 text-right" style="padding-top: 10px;">
                          <a href="../password/reset">I forgot my password</a>
                    </div>
                </div>
            </div>
          </form>
        </div>
    </div>


@stop
