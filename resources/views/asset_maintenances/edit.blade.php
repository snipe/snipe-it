@extends('layouts/default')

{{-- Page title --}}
@section('title')
@if ($item->id)
{{ trans('admin/asset_maintenances/form.update') }}
@else
{{ trans('admin/asset_maintenances/form.create') }}
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
  <div class="col-md-12">
    @if ($item->id)
    <form class="form-horizontal" method="post" action="{{ route('maintenances.update', $item->id) }}" autocomplete="off">
      {{ method_field('PUT') }}
      @else
      <form class="form-horizontal" method="post" action="{{ route('maintenances.store') }}" autocomplete="off">
        @endif
        <!-- CSRF Token -->
        {{ csrf_field() }}

        <div class="box box-default">
          <div class="box-header with-border">
            <h2 class="box-title">
              @if ($item)
              {{ $item->name }}
              @endif
            </h2>
          </div><!-- /.box-header -->

          <div class="box-body">
            @include ('partials.forms.edit.asset-select', ['translated_name' => trans('admin/hardware/table.asset_tag'), 'fieldname' => 'asset_id', 'required' => 'true'])
            @include ('partials.forms.edit.maintenance_type')
            @include ('partials.forms.edit.maintenance_title')

            <!-- Start Date -->
            <div class="form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
              <label for="start_date" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.start_date') }}</label>

              <div class="input-group col-md-3{{  (Helper::checkIfRequired($item, 'start_date')) ? ' required' : '' }}">
                <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-autoclose="true" data-date-clear-btn="true">
                  <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="start_date" id="start_date" value="{{ old('start_date', $item->start_date) }}">
                  <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                </div>
                {!! $errors->first('start_date', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
            </div>



            <!-- Completion Date -->
            <div class="form-group {{ $errors->has('completion_date') ? ' has-error' : '' }}">
              <label for="start_date" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.completion_date') }}</label>

              <div class="input-group col-md-3{{  (Helper::checkIfRequired($item, 'completion_date')) ? ' required' : '' }}">
                <div class="input-group date" data-date-clear-btn="true" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-autoclose="true">
                  <input type="text" class="form-control" placeholder="{{ trans('general.select_date') }}" name="completion_date" id="completion_date" value="{{ old('completion_date', $item->completion_date) }}">
                  <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                </div>
                {!! $errors->first('completion_date', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
            </div>

            <!-- Warranty -->
            <div class="form-group">
              <div class="col-sm-offset-3 col-sm-9">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" value="1" name="is_warranty" id="is_warranty" {{ Request::old('is_warranty', $item->is_warranty) == '1' ? ' checked="checked"' : '' }} class="minimal"> {{ trans('admin/asset_maintenances/form.is_warranty') }}
                  </label>
                </div>
              </div>
            </div>

            <!-- Asset Maintenance Cost -->
            <div class="form-group">
              <label class="col-md-3 control-label"></label>

              <div class="col-md-9 col-sm-9 col-md-offset-3">

                <a id="optional_info" class="text-primary">
                  <i class="fa fa-caret-right fa-2x" id="optional_info_icon"></i>
                  <strong>{{ trans('admin/hardware/form.optional_infos') }}</strong>
                </a>

              </div>

              <div id="optional_details" class="col-md-12" style="display:none">
                <br>
                @include ('partials.forms.edit.supplier-select', ['translated_name' => trans('general.supplier').' '.trans('general.maintenance'), 'fieldname' => 'supplier_id', 'required' => 'false'])
              </div>
            </div>

            <!-- <div class="form-group {{ $errors->has('cost') ? ' has-error' : '' }}">
              <label for="cost" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.cost') }}</label>
              <div class="col-md-2">
                <div class="input-group">
                  <span class="input-group-addon">
                    @if (($item->asset) && ($item->asset->location) && ($item->asset->location->currency!=''))
                    {{ $item->asset->location->currency }}
                    @else
                    {{ $snipeSettings->default_currency }}
                    @endif
                  </span>
                  <input class="col-md-2 form-control" type="text" name="cost" id="cost" value="{{ old('cost', Helper::formatCurrencyOutput($item->cost)) }}" />
                  {!! $errors->first('cost', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                </div>
              </div>
            </div> -->

            <!-- Notes -->
            <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
              <label for="notes" class="col-md-3 control-label">{{ trans('admin/asset_maintenances/form.notes') }}</label>
              <div class="col-md-7">
                <textarea class="col-md-6 form-control" id="notes" name="notes">{{ old('notes', $item->notes) }}</textarea>
                {!! $errors->first('notes', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
            </div>
          </div> <!-- .box-body -->

          <div class="box-footer text-right">
            <button type="submit" class="btn btn-success"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.save') }}</button>
          </div>
        </div> <!-- .box-default -->
      </form>
  </div>
</div>

@stop

@section('moar_scripts')
<script nonce="{{ csrf_token() }}">
  $(document).ready(function() {

    // Listen for changes in the select list
    $('#title-select').on('change', function() {
      $('#title-input').val($(this).val());
    });

    // Listen for changes in the input field
    $('#title-input').on('input', function() {
      var inputVal = $(this).val();
      $('#title-select option').filter(function() {
        return ($(this).text() === inputVal);
      }).prop('selected', true);
    });

    $("#optional_info").on("click", function() {
      $('#optional_details').fadeToggle(100);
      $('#optional_info_icon').toggleClass('fa-caret-right fa-caret-down');
      var optional_info_open = $('#optional_info_icon').hasClass('fa-caret-down');
      document.cookie = "optional_info_open=" + optional_info_open + '; path=/';
    });

    var all_cookies = document.cookie.split(';')
    for (var i in all_cookies) {
      var trimmed_cookie = all_cookies[i].trim(' ')
      if (trimmed_cookie.startsWith('optional_info_open=')) {
        elems = all_cookies[i].split('=', 2)
        if (elems[1] == 'true') {
          $('#optional_info').trigger('click')
        }
      }
    }

  });
</script>
@stop