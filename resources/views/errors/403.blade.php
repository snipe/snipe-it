@extends('layouts/basic')

{{-- Page title --}}
@section('title')
403
@parent
@stop

{{-- Page content --}}

@section('content')



<div class="row">
  <div class="col-md-8 col-md-offset-2">

    <div style="padding-top: 200px">
      <img src="{{ url('/') }}/img/sad-panda.png" style="width: 200px; height: 200px;" class="pull-left">
            <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i> 403 Forbidden.</h3>
              <p>
                您无权限做这件事， 单击 <a href="{{ url('/') }}">返回主页面</a>, 或者联系管理员.
              </p>

    </div>
</div>
@stop
