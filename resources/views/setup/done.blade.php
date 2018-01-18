@extends('layouts/setup')

{{-- Page title --}}
@section('title')
Create a User ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="col-lg-12" style="padding-top: 20px;">
	<div class="col-md-12">
        <div class="alert alert-warning">
            <i class="fa fa-check"></i>
           成功！管理员用户已被添加
        </div>
    </div>
    <p>单击这里去登录 <a href="{{ url('/') }}">{{ url('/') }}</a></p>
</div>
@stop
