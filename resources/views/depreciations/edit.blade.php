@extends('layouts/default')

{{-- Page title --}}
@section('title')

    @if ($depreciation->id)
        {{ trans('admin/depreciations/general.update_depreciation') }}
    @else
        {{ trans('admin/depreciations/general.create_depreciation') }}
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
        <!-- Name -->
        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-4 control-label">{{ trans('admin/depreciations/general.depreciation_name') }}
             <i class='fa fa-asterisk'></i></label>
             </label>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $depreciation->name) }}" />
                    {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                </div>
        </div>

        <!-- Name -->
        <div class="form-group {{ $errors->has('months') ? ' has-error' : '' }}">
            <label for="months" class="col-md-4 control-label">{{ trans('admin/depreciations/general.number_of_months') }}
             <i class='fa fa-asterisk'></i></label>
             </label>
                <div class="col-md-6">
                    <input class="form-control" type="text" name="months" id="months" value="{{ Input::old('months', $depreciation->months) }}" style="width: 80px;" />
                    {!! $errors->first('months', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
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
    <h4>{{ trans('admin/depreciations/general.about_asset_depreciations') }}</h4>
    <p>{{ trans('admin/depreciations/general.about_depreciations') }} </p>
</div>
</div>

@stop
