@extends('layouts.default')

{{-- Page title --}}
@section('title')
    @if ($item->id)
        {{ $updateText }}
    @else
        {{ $createText }}
    @endif
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
    {{ trans('general.back') }}</a>
@stop



{{-- Page content --}}

@section('content')

<!-- row -->
<div class="row">
    <!-- col-md-8 -->
    <div class="col-md-8 col-md-offset-2">

        <form id="create-form" class="form-horizontal" method="post" action="{{ (isset($formAction)) ? $formAction : \Request::url()  }}" autocomplete="off" role="form" enctype="multipart/form-data">

        <!-- box -->
        <div class="box box-default">
            <!-- box-header -->
            <div class="box-header with-border">

            <h3 class="box-title" style="min-height: 20px;">
            @if (isset($helpText))
                @include ('partials.more-info',
                    [
                        'helpText' => $helpText,
                        'helpPosition' => (isset($helpPosition)) ? $helpPosition : 'left'
                    ])
            @endif

            @if ($item->id)
            {{ $item->display_name }}
            @endif
            </h3>
                @if (isset($topSubmit))
                <div class="box-tools pull-right">
                 @include('partials.forms.edit.submit-button')
                </div>
                @endif
            </div><!-- /.box-header -->

            <!-- box-body -->
            <div class="box-body">

                    @if ($item->id)
                    {{ method_field('PUT') }}
                    @endif

                    <!-- CSRF Token -->
                    {{ csrf_field() }}
                    @yield('inputFields')
                    @include('partials.forms.edit.submit')

            </div> <!-- ./box-body -->
        </div> <!-- box -->
        </form>
    </div> <!-- col-md-8 -->

</div><!-- ./row -->

@stop
