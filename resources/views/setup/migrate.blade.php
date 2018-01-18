@extends('layouts/setup')

{{-- Page title --}}
@section('title')
Create a User ::
@parent
@stop

{{-- Page content --}}
@section('content')
<div class="col-lg-12" style="padding-top: 20px;">
    @if (trim($output)=='Nothing to migrate.')
    <div class="col-md-12">
        <div class="alert alert-warning">
            <i class="fa fa-warning"></i>
            没有要导入的，你的数据库表已生成
        </div>
    </div>
    @else
    <div class="col-md-12">
        <div class="alert alert-success">
            <i class="fa fa-check"></i>
            你的数据库表已生成
        </div>
    </div>

    @endif

    <p>迁移的输出</p>
    <pre>{{ $output }}</pre>
</div>
@stop

@section('button')
  <form action="{{ route('setup.user') }}" method="GET">
    <button class="btn btn-primary">下一步：创建用户</button>
  </form>
@parent
@stop
