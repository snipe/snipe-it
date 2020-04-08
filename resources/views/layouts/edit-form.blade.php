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
        <div class="box box-default">
            <div class="box-header{{  ($item->id) ? ' with-border' : ''  }}">

            @if ($item->id)
                    <h2 class="box-title">
                        {{ $item->display_name }}
                    </h2>
            @endif

                @if (isset($helpText))
                    <div class="box-tools pull-right">
                        <button class="slideout-menu-toggle btn btn-box-tool btn-box-tool-lg" data-toggle="tooltip" title="Help"><i class="fa fa-question" aria-hidden="true"></i>
                        <span class="sr-only">Help</span>
                        </button>
                    </div>
                @endif
            </div><!-- /.box-header -->

            <div class="box-body">
                <form id="create-form" class="form-horizontal" method="post" action="{{ (isset($formAction)) ? $formAction : \Request::url()  }}" autocomplete="off" role="form" enctype="multipart/form-data">

                    @if ($item->id)
                    {{ method_field('PUT') }}
                    @endif


                    <!-- CSRF Token -->
                    {{ csrf_field() }}
                    @yield('inputFields')
                    @include('partials.forms.edit.submit')
                </form>
            </div>
        </div>
    </div>

    @if ((isset($helpText)) && (isset($helpTitle)))
    <div class="slideout-menu">
        <a href="#" class="slideout-menu-toggle pull-right">×</a>
        <h2>
            {{ $helpTitle}}
        </h2>
        <p>{{ $helpText }} </p>
    </div>
    @endif
</div>

@stop
