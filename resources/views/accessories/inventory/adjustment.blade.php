@extends('layouts/default')

{{-- Page title --}}
@section('title')
  @if ($item->id)
    {{ trans('form.update', ['name' => trans('general.invadjust')]) }}
  @else
    {{ trans('form.create', ['name' => trans('general.invadjust')]) }}
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
    @if ($item->id)
      <form class="form-horizontal" method="post" action="{{ route('invadjusts.update', $item->id) }}" autocomplete="off">
      {{ method_field('PUT') }}
    @else
      <form class="form-horizontal" method="post" action="{{ route('invadjusts.store') }}" autocomplete="off">
    @endif
    <!-- CSRF Token -->
    {{ csrf_field() }}

    <div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">
          @if ($item)
          {{ $item->name }}
          @endif
        </h3>
      </div><!-- /.box-header -->

      <div class="box-body">
        @include ('partials.forms.inventory-item-selector')

        @include ('partials.forms.edit.inventory-from-state-select', ['translated_name' => trans('admin/inventory/general.from_state'), 'fieldname' => 'from_state', 'required' => 'true'])
        @include ('partials.forms.edit.inventory-to-state-select', ['translated_name' => trans('admin/inventory/general.to_state'), 'fieldname' => 'to_state', 'required' => 'true'])
        @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'stock_location_id'])
        @include ('partials.forms.edit.quantity')
        @include ('partials.forms.edit.occurred_at')
        @include ('partials.forms.edit.price')
        @include ('partials.forms.edit.notes')
      </div>

        

        <div class="box-footer text-right">
          <button type="submit" class="btn btn-success"><i class="fa fa-check icon-white"></i> {{ trans('general.save') }}</button>
        </div>
      </div> <!-- .box-default -->
    </form>
  </div>
</div>

@stop
