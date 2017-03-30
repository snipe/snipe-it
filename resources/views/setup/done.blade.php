@extends('layouts/setup')

{{-- Page title --}}
@section('title')
{{ trans('admin/setup/general.summary') }} ::
@parent
@stop

{{-- Page content --}}
@section('content')




      <div class="col-lg-12" style="padding-top: 20px;">

        <div class="col-md-12">
            <div class="alert alert-warning">
                <i class="fa fa-check"></i>
                {{ trans('admin/setup/general.admin_added') }}
            </div>
        </div>

        <p>{{ trans('admin/setup/general.click_to_login') }}<a href="{{ config('app.url') }}">{{ config('app.url') }}</a></p>

      </div>

@stop
