@extends('layouts/basic')


{{-- Page content --}}
@section('content')


    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
        {!! csrf_field() !!}

        <div class="container">
            <div class="row">

                <div class="col-md-6 col-md-offset-3">

                    <div class="box login-box" style="width: 100%">
                        <div class="box-header with-border">
                            <h2 class="box-title"> {{ trans('auth/general.reset_password')  }}</h2>
                        </div>


                        <div class="login-box-body">
                            <div class="row">

                                <!-- Notifications -->
                                <x-notifications />



                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                                        <label class="col-md-4 control-label"><x-icon type="user" /> {{ trans('admin/users/table.username')  }}</label>

                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="username" value="{{ old('username', $username) }}">
                                            <x-form.error name="username" />

                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="password">
                                <x-icon type="password" />
                                {{ trans('admin/users/table.password')  }}
                            </label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password" aria-label="password">
                                <x-form.error name="password" />
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label" for="password_confirmation">
                                <x-icon type="password" />
                                {{ trans('admin/users/table.password_confirm')  }}</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation" aria-label="password_confirmation">
                                <x-form.error name="password_confirmation" />

                            </div>
                        </div>


                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-lg btn-primary btn-block">
                                {{ trans('auth/general.reset_password')  }}
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</form>

@stop


