@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
     @lang('general.import') ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ URL::previous() }}" class="btn-flat gray pull-right"><i class="fa fa-arrow-left icon-white"></i>  @lang('general.back')</a>
        <h3> @lang('general.import')</h3>
    </div>
</div>


Your process has started.


@stop
