@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($manufacturer->id)
        {{ trans('admin/manufacturers/table.update') }}
    @else
        {{ trans('admin/manufacturers/table.create') }}
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

  <form class="form" method="post" action="" autocomplete="off">
  <!-- CSRF Token -->
  <input type="hidden" name="_token" value="{{ csrf_token() }}">

  
  <!-- Horizontal Form -->
    <div class="box box-default">
      @if ($manufacturer->id)
      <div class="box-header with-border">
        <h3 class="box-title">{{ $manufacturer->name }}</h3>
      </div><!-- /.box-header -->
      @endif

      <div class="box-body">


        <!-- Name -->
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
          <label for="name" class="col-md-3 control-label">{{ trans('admin/manufacturers/table.name') }}
           </label>
          <div class="col-md-9 required">
              <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $manufacturer->name) }}" />
              {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
          </div>
          </div>

      </div>
      <div class="box-footer text-right">
        <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
      </div>
    </div>
    </form>
</div>

    <!-- side address column -->
   <div class="col-md-3">
        <h4>Have Some Haiku</h4>
        <p>Serious error.<br>
        All shortcuts have disappeared.<br>
        Screen. Mind. Both are blank.</p>


    </div>

</div>

@stop
