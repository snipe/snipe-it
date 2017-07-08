@extends('layouts/default')

{{-- Page title --}}
@section('title')
    PHP Info
    @parent
@stop

@section('header_right')
    <a href="{{ route('settings.index') }}" class="btn btn-default"> {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')
    @if (config('app.debug')=== true)
    <div class="row">
        <div class="col-md-12">
           <?php phpinfo(); ?>
        </div> <!-- /.col-md-12-->
    </div> <!-- /.row-->

    @else
        <div class="col-md-12">
            <div class="alert alert-danger">
                This information is only available when debug is enabled.
            </div>
    @endif


@stop
