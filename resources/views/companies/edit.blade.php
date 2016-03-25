@extends('layouts/default')

{{-- Page title --}}
@section('title')
  @if ($company->id)
    {{ trans('admin/companies/table.update') }}
  @else
    {{ trans('admin/companies/table.create') }}
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
      @if ($company->id)
        <div class="box-header with-border">
          <h3 class="box-title">{{ $company->name }}</h3>
        </div><!-- /.box-header -->
      @endif

       <div class="box-body">

         <!-- Company Name -->
          <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name" class="col-md-3 control-label">{{ trans('admin/companies/table.name') }}
            <i class='fa fa-asterisk'></i></label>
          </label>
          <div class="col-md-9">
              <input class="form-control" type="text" name="name" id="name" value="{{ Input::old('name', $company->name) }}" />
            {!! $errors->first('name', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
            </div>
          </div>
          <!-- /Company Name -->

       </div>
       <!-- /Panel body -->
       <div class="box-footer text-right">
           <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
       </div>
       <!-- /Panel footer -->
   </div>
   <!-- /Panel  -->
</form>
</div>
    <!-- side address column -->
    <div class="col-md-3">

      <h4>About Companies</h4>
      <p>
        Companies can be used as a simple identifier field, or can be used to limit visibility of assets, users, etc if full company support is enabled in your Admin settings.
      </p>
    </div>
  </div>
</div>

@stop
