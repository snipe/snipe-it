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

            <!-- Note -->
            <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
              <label for="note" class="col-md-3 control-label">{{ trans('admin/hardware/form.notes') }}</label>
              <div class="col-md-7">
                <textarea class="col-md-6 form-control" id="note" name="note">{{ old('note', $component->note) }}</textarea>
                {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
            </div>

            <!-- Serials -->
            <div class="form-group {{ $errors->has('serials') ? 'error' : '' }}">
              <label for="serials" class="col-md-3 control-label">Serials</label>
              <div class="col-md-7">
                <textarea class="col-md-6 form-control" id="serials" name="serials" rows="4"
                          placeholder="Enter serials that are to be checked out seperated by a comma or new line.">{{ old('serials') }}</textarea>
                {!! $errors->first('serials', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
              </div>
            </div>

            <!-- Serials Checkboxes -->
            <div class="form-group">
              <label for="serials" class="col-md-2 control-label">&nbsp;</label>
              <div class="col-md-7">
                @foreach($component->serials as $serial)
                  @if($serial->status == 0)
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="serials_list[]" value="{{ $serial->serial_number }}" />
                      {{ $serial->serial_number }}
                    </label>
                  </div>
                  @endif
                @endforeach
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

@section('moar_scripts')
  <script type="application/javascript">
    $(document).ready(function() {
      // If the user has selected serials from the list "serials_list", then clear the serials textarea field
      // and add the serials to the textarea field.
      $('input[name="serials_list[]"]').on('change', function() {
        var serials = $('textarea[name="serials"]').val();
        var serials_list = $('input[name="serials_list[]"]:checked').map(function() {
          return this.value;
        }).get();

        $('textarea[name="serials"]').val(serials_list.join("\n"));

        // Update the assigned_qty field to match the number of serials selected
        $('input[name="assigned_qty"]').val(serials_list.length);
      });
    });
  </script>
@stop
