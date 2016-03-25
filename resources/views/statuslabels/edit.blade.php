@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($statuslabel->id)
        {{ trans('admin/statuslabels/table.update') }}
    @else
        {{ trans('admin/statuslabels/table.create') }}
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
  <div class="col-md-9">
    <form class="form-horizontal" method="post" action="" autocomplete="off">

        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

        <div class="box box-default">
          <div class="box-body">
            <!-- Asset Title -->
            <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-3 control-label">{{ trans('general.name') }}
                <i class='fa fa-asterisk'></i></label>
                </label>
                    <div class="col-md-7">
                        <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $statuslabel->name) }}" />
                        {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                    </div>
            </div>


            <!-- Note -->
            <div class="form-group {{ $errors->has('notes') ? 'has-error' : '' }}">
                <label for="notes" class="col-md-3 control-label">{{ trans('admin/hardware/form.notes') }}</label>
                <div class="col-md-7">
                    <textarea class="col-md-12 form-control" id="notes" name="notes">{{ Input::old('notes', $statuslabel->notes) }}</textarea>
                    {!! $errors->first('notes', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                </div>
            </div>


            <!-- Label type -->
            <div class="form-group {{ $errors->has('statuslabel_types') ? 'has-error' : '' }}">
                <label for="statuslabel_types" class="col-md-3 control-label">{{ trans('admin/statuslabels/table.status_type') }}
                <i class='fa fa-asterisk'></i></label>
                </label>
                <div class="col-md-7">
                    {{ Form::select('statuslabel_types', $statuslabel_types, $statuslabel->getStatuslabelType(), array('class'=>'select2', 'style'=>'min-width:400px')) }}
                    {!! $errors->first('statuslabel_types', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                </div>
            </div>

          </div>
          <div class="box-footer text-right">
                <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
          </div>
      </div>
</div>

<!-- side address column -->
<div class="col-md-3">
    <h6>{{ trans('admin/statuslabels/table.about') }}</h6>
    <p>{{ trans('admin/statuslabels/table.info') }}</p>

</div>
</div>


@stop
