@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/accessories/general.checkout') }}
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
      @if ($accessory->id)
        <div class="box-header with-border">
          <h3 class="box-title">{{ $accessory->name }}</h3>
        </div><!-- /.box-header -->
      @endif

       <div class="box-body">
         @if ($accessory->name)
          <!-- accessory name -->
          <div class="form-group">
            <label class="col-sm-3 control-label">{{ trans('admin/accessories/general.accessory_name') }}</label>
            <div class="col-md-6">
              <p class="form-control-static">{{ $accessory->name }}</p>
            </div>
          </div>
          @endif

          @if ($accessory->category->name)
          <!-- accessory name -->
          <div class="form-group">
            <label class="col-sm-3 control-label">{{ trans('admin/accessories/general.accessory_category') }}</label>
            <div class="col-md-6">
              <p class="form-control-static">{{ $accessory->category->name }}</p>
            </div>
          </div>
          @endif

          <!-- User -->

          <div class="form-group {{ $errors->has('assigned_to') ? ' has-error' : '' }}">
            <label for="assigned_to" class="col-md-3 control-label">
              {{ trans('admin/hardware/form.checkout_to') }}
              <i class='icon-asterisk'></i>
            </label>
            <div class="col-md-9">
                {{ Form::select('assigned_to', $users_list , Input::old('assigned_to', $accessory->assigned_to), array('class'=>'select2', 'style'=>'min-width:350px')) }}
                {!! $errors->first('assigned_to', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
            </div>
          </div>

          @if ($accessory->category->require_acceptance=='1')
          <div class="form-group">
            <div class="col-md-9 col-md-offset-3">
              <p class="hint-block">{{ trans('admin/categories/general.required_acceptance') }}</p>
            </div>
          </div>
          @endif

          @if ($accessory->getEula())
          <div class="form-group">
            <div class="col-md-9 col-md-offset-3">
              <p class="hint-block">{{ trans('admin/categories/general.required_eula') }}</p>
            </div>
          </div>
          @endif

       </div>
       <div class="box-footer">
          <a class="btn btn-link" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-check icon-white"></i> {{ trans('general.checkout') }}</button>
       </div>
    </div> <!-- .box.box-default -->
  </form>
  </div> <!-- .col-md-9-->
</div> <!-- .row -->


@stop
