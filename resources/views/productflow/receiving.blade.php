@extends('layouts/default')
@section('title')
    Receiving
    @parent
@stop

@section('content')
    <div class="row">
        <!-- col-md-8 -->
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">

            <form id="create-form" class="form-horizontal" method="get" action="{{ route('productflow.receiving.show') }}"
                autocomplete="off" role="form" enctype="multipart/form-data">

                <!-- box -->
                <div class="box box-default">
                    <!-- box-header -->
                    <div class="box-header with-border text-right">

                        <div class="col-md-12 box-title text-right" style="padding: 0px; margin: 0px;">

                            <div class="col-md-12" style="padding: 0px; margin: 0px;">
                                <div class="col-md-9 text-left">
                                    <h2>Receive Parts</h2>
                                </div>
                                <div class="col-md-3 text-right" style="padding-right: 10px;">
                                    <a class="btn btn-link text-left" href="{{ URL::previous() }}">
                                        {{ trans('button.cancel') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check icon-white" aria-hidden="true"></i>
                                        Receive
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.box-header -->

                    <!-- box-body -->
                    <div class="box-body">

                        <div class="form-group">
                            <label for="receiveParts" class="col-md-3 control-label">Search</label>
                            <div class="col-md-7 required">

                                <input class="form-control" type="text" name="receiveParts" data-validation="required"
                                    id="receiveParts" />

                            </div>
                            @php
                                $result = Session::get('model');
                            @endphp

                            <div class="col-md-1 col-sm-1 text-left">
                                <a href='{{ route('modal.show', 'model') }}' data-toggle="modal" data-target="#createModal"
                                    data-select='model_select_id' class="btn btn-sm btn-primary"
                                    >{{ trans('button.new') }}</a>
                                    <a href='{{ route('modal.show', ['type' => 'serialnumber', 'result' => Session::get('model')]) }}' data-toggle="modal" data-target="#createModal"
                                     class="btn btn-sm btn-primary" id="test" hidden="true"
                                    >{{ trans('button.new') }}</a>
                                    
                            </div>
                        </div>
                        <!-- CSRF Token -->
                        {{ csrf_field() }}
                        {{-- @yield('inputFields') --}}
                    </div>

                </div> <!-- ./box-body -->
        </div> <!-- box -->
        </form>
    </div> <!-- col-md-8 -->

    </div><!-- ./row -->

@stop

@section('moar_scripts')
    @if (Session::get('model'))
        <script >
            $(document).ready(() => {
                // let serialNumber = prompt("Serial number required for {{ $result }}");
                $("#test").click();
            })
        </script>
    @endif
    @include ('partials.bootstrap-table')
@stop
