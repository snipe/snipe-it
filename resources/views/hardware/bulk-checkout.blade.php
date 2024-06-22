@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/hardware/general.bulk_checkout') }}
@parent
@stop

{{-- Page content --}}
@section('content')

<style>
  .input-group {
    padding-left: 0px !important;
  }
</style>


<div class="row">
  <!-- left column -->
  <div class="col-md-12">
    <form class="form-horizontal" method="post" action="{{ route('hardware.bulkcheckout.store') }}" autocomplete="off">
      {{ csrf_field() }}
    <!-- show asset to be checkedout -->
     <!-- selected assets -->
      @foreach ($assets as $asset)
        <input type="hidden" name="selected_assets[]" value="{{$asset->id}}">
      @endforeach
    <div class="box box-default">
      <div class="box-header with-border">
      </div>

      <div class="box-body">
        <table class="table table-striped table-condensed">
          <thead>
            <tr>
              <td>{{ trans('admin/hardware/table.id') }}</td>
              <td>{{ trans('admin/hardware/table.asset_tag') }}</td>
              <td>{{ trans('admin/hardware/form.notes') }}</td>
              
            </tr>
          </thead>
          <tbody>
            @foreach ($assets as $asset)
            <tr>
              <td>{{ $asset->id }}</td>
              <td>{{ $asset->present()->name() }}</td>
              <td>
                <div class="">
                  <textarea class="col-md-6 form-control" id="note" name="note[]">{{ old('note', $asset->note) }}</textarea>
                  {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                  </div>
              </td>
              
            </tr>
            @endforeach
          </tbody>
        </table>
      </div><!-- /.box-body -->

    </div><!-- /.box -->


    <div class="box box-default">
      <div class="box-body">
        
          <!-- Checkout selector -->
          @include ('partials.forms.checkout-selector', ['user_select' => 'true','asset_select' => 'true', 'location_select' => 'true'])

          @include ('partials.forms.edit.user-select', ['translated_name' => trans('general.user'), 'fieldname' => 'assigned_user', 'required'=>'true'])
          @include ('partials.forms.edit.asset-select', ['translated_name' => trans('general.asset'), 'fieldname' => 'assigned_asset', 'unselect' => 'true', 'style' => 'display:none;', 'required'=>'true'])
          @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'assigned_location', 'style' => 'display:none;', 'required'=>'true'])

          
          <!-- Checkout/Checkin Date -->
              <div class="form-group {{ $errors->has('checkout_at') ? 'error' : '' }}">
                  {{ Form::label('checkout_at', trans('admin/hardware/form.checkout_date'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-8">
                      <div class="input-group date col-md-5" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-end-date="0d" data-date-clear-btn="true">
                          <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="checkout_at" id="checkout_at" value="{{ old('checkout_at') }}">
                          <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                      </div>
                      {!! $errors->first('checkout_at', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                  </div>
              </div>

              <!-- Expected Checkin Date -->
              <div class="form-group {{ $errors->has('expected_checkin') ? 'error' : '' }}">
                  {{ Form::label('expected_checkin', trans('admin/hardware/form.expected_checkin'), array('class' => 'col-md-3 control-label')) }}
                  <div class="col-md-8">
                      <div class="input-group date col-md-5" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-start-date="0d" data-date-clear-btn="true">
                          <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="expected_checkin" id="expected_checkin" value="{{ old('expected_checkin') }}">
                          <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                      </div>
                      {!! $errors->first('expected_checkin', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                  </div>
              </div>


      <h4>Responsable destination</h4>
      <!-- checkout responsable name -->
      <div class="form-group {{ $errors->has('responsable') ? 'error' : '' }}">
          {{ Form::label('responsable', trans('admin/hardware/form.responsable'), array('class' => 'col-md-3 control-label')) }}
          <div class="col-md-8">
              <input class="form-control" type="text" name="responsable" id="responsable" value="{{ old('responsable') }}" tabindex="1" data-validation="">
              {!! $errors->first('responsable', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
          </div>
      </div>

      <!-- checkout responsable matricule -->
      <div class="form-group {{ $errors->has('responsable_matricule') ? 'error' : '' }}">
          {{ Form::label('responsable_matricule', trans('admin/hardware/form.responsable_matricule'), array('class' => 'col-md-3 control-label')) }}
          <div class="col-md-8">
              <input class="form-control" type="text" name="responsable_matricule" id="responsable_matricule" value="{{ old('responsable_matricule') }}" tabindex="1" data-validation="">
              {!! $errors->first('responsable_matricule', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
          </div>
      </div>

      </div> <!--./box-body-->
      <div class="box-footer">
        <a class="btn btn-link" href="{{ URL::previous() }}"> {{ trans('button.cancel') }}</a>
        <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.checkout') }}</button>
      </div>
    </div>
  </form>
  </div> <!--/.col-md-7-->

  <!-- right column -->
  <div class="col-md-5" id="current_assets_box" style="display:none;">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h2 class="box-title">{{ trans('admin/users/general.current_assets') }}</h2>
      </div>
      <div class="box-body">
        <div id="current_assets_content">
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('moar_scripts')
@include('partials/assets-assigned')

@stop
