@extends('layouts/default')

{{-- Page title --}}
@section('title')
  @if ($item->id)
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



    <form class="form-horizontal" method="post" autocomplete="off">
    {{ csrf_field() }}
    <div class="box box-default">

       <div class="box-body">

         @include ('partials.forms.edit.name', ['translated_name' => trans('admin/companies/table.name')])
       </div>
       <!-- /Panel body -->
       @include ('partials.forms.edit.submit')

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
