@extends('layouts/default')

{{-- Page title --}}
@section('title')
 {{ trans('admin/components/general.checkout') }}
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
  <div class="col-md-9">
    <form class="form-horizontal" method="post" action="" autocomplete="off">
      <!-- CSRF Token -->
      {{ csrf_field() }}

      <div class="box box-default">
        @if ($component->id)
        <div class="box-header with-border">
          <div class="box-heading">
            <h2 class="box-title">{{ $component->name }}  ({{ $component->numRemaining()  }}  {{ trans('admin/components/general.remaining') }})</h2>
          </div>
        </div><!-- /.box-header -->
        @endif

        <div class="box-body">
          @if ($component->name)
          <!-- consumable name -->
          <div class="form-group">
            <label class="col-sm-3 control-label">{{ trans('admin/components/general.component_name') }}</label>
            <div class="col-md-6">
              <p class="form-control-static">{{ $component->name }}</p>
            </div>
          </div>
          @endif

          <!-- Asset -->
            @include ('partials.forms.edit.asset-select', ['translated_name' => trans('general.select_asset'), 'fieldname' => 'asset_id'])

            <div class="form-group {{ $errors->has('assigned_qty') ? ' has-error' : '' }}">
              <label for="assigned_qty" class="col-md-3 control-label">{{ trans('general.qty') }}
                <i class='icon-asterisk'></i></label>
              <div class="col-md-9">
                <input class="form-control" type="text" name="assigned_qty" id="assigned_qty" style="width: 70px;" value="{{ old('assigned_qty') ?? 1 }}" />
                {!! $errors->first('assigned_qty', '<br><span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
            </div>


        </div> <!-- .BOX-BODY-->
        <div class="box-footer">
          <a class="btn btn-link" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
          <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.checkout') }}</button>
       </div>
      </div> <!-- .box-default-->
    </form>
  </div> <!-- .col-md-9-->
</div> <!-- .row -->

@stop
