@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/licenses/general.checkin') }}
@parent
@stop


@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-7">
            <form class="form-horizontal" method="post" action="{{ route('licenses.checkin.save', ['licenseId'=>$licenseSeat->id, 'backTo'=>$backto] ) }}" autocomplete="off">
                {{csrf_field()}}

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h2 class="box-title"> {{ $licenseSeat->license->name }}</h2>
                    </div>
                    <div class="box-body">

            <!-- license name -->
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin/hardware/form.name') }}</label>
                <div class="col-md-6">
                    <p class="form-control-static">{{ $licenseSeat->license->name }}</p>
                </div>
            </div>

            <!-- Serial -->
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin/hardware/form.serial') }}</label>
                <div class="col-md-6">
                    <p class="form-control-static">
                        @can('viewKeys', $licenseSeat->license)
                            {{ $licenseSeat->license->serial }}
                        @else
                            ------------
                        @endcan
                        </p>
                </div>
            </div>

            <!-- Note -->
            <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                <label for="note" class="col-md-2 control-label">{{ trans('admin/hardware/form.notes') }}</label>
                <div class="col-md-7">
                    <textarea class="col-md-6 form-control" id="note" name="note">{{ old('note', $licenseSeat->note) }}</textarea>
                    {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                </div>
            </div>
                        <div class="box-footer">
                            <a class="btn btn-link" href="{{ route('licenses.index') }}">{{ trans('button.cancel') }}</a>
                            <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.checkin') }}</button>
                        </div>
                    </div> <!-- /.box-->
            </form>
        </div> <!-- /.col-md-7-->
    </div>


@stop
