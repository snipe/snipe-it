@extends('layouts/basic')


{{-- Page content --}}
@section('content')

    @if ($snipeSettings->custom_forgot_pass_url)
        <a href="{{ $snipeSettings->custom_forgot_pass_url  }}" rel="noopener">{{ trans('auth/general.forgot_password')  }}</a>
    @else

    <form class="form" role="form" method="POST" action="{{ url('/password/email') }}">
        {!! csrf_field() !!}
    <div class="container">
        <div class="row">



            <div class="col-md-4 col-md-offset-4">

                <div class="box login-box" style="width: 100%">
                        <div class="box-header">
                            <h2 class="box-title"> {{ trans('auth/general.send_password_link')  }}</h2>
                        </div>


                        <div class="login-box-body">
                            <div class="row">

                                <!-- Notifications -->
                                @include('notifications')



                                    <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">

                                        <div class="col-md-12">
                                            <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="{{ trans('admin/users/table.username') }}" aria-label="username">
                                            {!! $errors->first('username', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                                        </div>
                                    </div>



                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-lg btn-primary btn-block">
                                {{ trans('auth/general.email_reset_password')  }}
                                </button>
                        </div>

                    </div>
            </div>
        </div>
    </div>

    </form>

    @endif
@stop

