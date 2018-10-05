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

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <form id="create-form" class="form-horizontal" method="post" action="{{ (isset($formAction)) ? $formAction : \Request::url()  }}" autocomplete="off" role="form" enctype="multipart/form-data">

        <div class="box box-default">
            <div class="box-header with-border">
            <h3 class="box-title" style="min-height: 20px;">
            @if ($item->id)
            {{ $item->display_name }}
            @endif
            </h3>
                <div class="box-tools pull-right">
                @if (isset($helpText))
                    <button class="slideout-menu-toggle btn btn-box-tool btn-box-tool-lg" data-toggle="tooltip" title="Help"><i class="fa fa-question"></i></button>
                @endif
                 @include('partials.forms.edit.submit-button')
                </div>
            </div><!-- /.box-header -->

            <div class="box-body">

                    @if ($item->id)
                    {{ method_field('PUT') }}
                    @endif

                    <!-- CSRF Token -->
                    {{ csrf_field() }}
                    @yield('inputFields')
                    @include('partials.forms.edit.submit')

            </div>
        </div>
    </div>
    </form>

    @if ((isset($helpText)) && (isset($helpTitle)))
    <div class="slideout-menu">
        <a href="#" class="slideout-menu-toggle pull-right">×</a>
        <h3>
            {{ $helpTitle}}
        </h3>
        <p>{{ $helpText }} </p>
    </div>
    @endif
</div>

@stop
