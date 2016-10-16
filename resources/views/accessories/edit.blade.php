@extends('layouts/default')

{{-- Page title --}}
@section('title')
    @if ($item->id)
        {{ trans('admin/accessories/general.update') }}
    @else
        {{ trans('admin/accessories/general.create') }}
    @endif
@parent
@stop

@section('header_right')
<a href="{{ URL::previous() }}" class="btn btn-primary">
  {{ trans('general.back') }}</a>



@stop


{{-- Page content --}}
@section('content')


<div class="row">
  <div class="col-md-8 col-md-offset-2">

    <div class="box box-default">

      <div class="box-header with-border">

          <h3 class="box-title">
            @if ($item->id)
            {{ $item->name }}
            @endif
          </h3>
          <div class="box-tools pull-right">
            <button class="slideout-menu-toggle btn btn-box-tool btn-box-tool-lg" data-toggle="tooltip" title="Help"><i class="fa fa-question"></i></button>
          </div>
      </div><!-- /.box-header -->




      <!-- form start -->
      <form class="form-horizontal" method="post" action="" autocomplete="off">

      <!-- CSRF Token -->
      <input type="hidden" name="_token" value="{{ csrf_token() }}" />

      <div class="box-body">
        <div class="col-md-0 col-md-offset-1">

        @include ('partials.forms.edit.company')
        @include ('partials.forms.edit.name', ['translated_name' => trans('admin/accessories/general.accessory_name')])
        @include ('partials.forms.edit.category')
        @include ('partials.forms.edit.manufacturer')
        @include ('partials.forms.edit.location')
        @include ('partials.forms.edit.order_number')
        @include ('partials.forms.edit.purchase_date')
        @include ('partials.forms.edit.purchase_cost')
        @include ('partials.forms.edit.quantity')
        @include ('partials.forms.edit.minimum_quantity')
      </div>

      @include ('partials.forms.edit.submit')
    </div>
  </div>


</form>

</div>
</div>


<div class="slideout-menu">
  <a href="#" class="slideout-menu-toggle pull-right">×</a>
	<h3>
    {{ trans('admin/accessories/general.about_accessories_title') }}
  </h3>
	<p>{{ trans('admin/accessories/general.about_accessories_text') }} </p>
</div>

@stop
