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
            <div class="box-header{{  ($item->id) ? ' with-border' : ''  }}">

            <div class="box-title col-md-12" style="min-height: 20px;">

                <div class="col-md-12">

                    @if (isset($helpText))
                        <div class="col-md-1 text-left" style="horiz-align: center;">
                        @include ('partials.more-info',
                            [
                                'helpText' => $helpText,
                                'helpPosition' => (isset($helpPosition)) ? $helpPosition : 'left'
                            ])
                        </div>
                    @endif

                        @if ($item->id)
                            <div class="col-md-9">
                                <h2 class="box-title">
                                    {{ $item->display_name }}
                                </h2>
                            </div>
                        @endif

                        @if ((isset($topSubmit)) && ($topSubmit =='true'))
                            <div class="col-md-2 text-right">
                            @include('partials.forms.edit.submit-button')
                            </div>
                        @endif

                </div> <!-- /div.row -->



            </div><!-- /.box-header -->
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
