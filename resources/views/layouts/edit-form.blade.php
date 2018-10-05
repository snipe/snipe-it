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
            @if (isset($helpText))
                @include ('partials.more-info',
                    [
                        'helpText' => trans('help.audit_help'),
                        'helpPosition' => (isset($helpPosition)) ? $helpPosition : 'left'
                    ])
            @endif

            @if ($item->id)
            {{ $item->display_name }}
            @endif
            </h3>
                <div class="box-tools pull-right">
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
</div>

@stop
