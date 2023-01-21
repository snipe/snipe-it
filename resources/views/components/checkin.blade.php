@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/components/general.checkin') }}
    @parent
@stop


@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
    <div class="row">
        <!-- left column -->
        <div class="col-md-7">
            <form class="form-horizontal" method="post" action="{{ route('components.checkin.store', $component_assets->id) }}" autocomplete="off">
                {{csrf_field()}}

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h2 class="box-title"> {{ $component->name }}</h2>
                    </div>
                    <div class="box-body">

                        <!-- Checked out to -->
                        <div class="form-group">
                            <label class="col-sm-2 control-label">{{ trans('general.checkin_from') }}</label>
                            <div class="col-md-6">
                                <p class="form-control-static">{{ $asset->present()->fullName }}</p>
                            </div>
                        </div>


                        <!-- Qty -->
                        <div class="form-group {{ $errors->has('checkin_qty') ? 'error' : '' }}">
                            <label for="checkin_qty" class="col-md-2 control-label">{{ trans('general.qty') }}</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" name="checkin_qty" aria-label="checkin_qty" value="{{ old('assigned_qty', $component_assets->assigned_qty) }}">
                            </div>
                            <div class="col-md-9 col-md-offset-2">
                            <p class="help-block">Must be {{ $component_assets->assigned_qty }} or less.</p>
                            {!! $errors->first('checkin_qty', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i>
                            :message</span>') !!}
                            </div>
                        </div>

                        <!-- Note -->
                        <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                            <label for="note" class="col-md-2 control-label">{{ trans('admin/hardware/form.notes') }}</label>
                            <div class="col-md-7">
                                <textarea class="col-md-6 form-control" id="note" name="note">{{ old('note', $component->note) }}</textarea>
                                {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- Serials -->
                        <div class="form-group {{ $errors->has('serials') ? 'error' : '' }}">
                            <label for="serials" class="col-md-2 control-label">Serials</label>
                            <div class="col-md-7">
                                <textarea class="col-md-6 form-control" id="serials" name="serials" rows="4"
                                          placeholder="Enter serials that are to be checked in seperated by a comma or new line.">{{ old('serials') }}</textarea>
                                {!! $errors->first('serials', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- Serials Checkboxes -->
                        <div class="form-group">
                            <label for="serials" class="col-md-2 control-label">&nbsp;</label>
                            <div class="col-md-7">
                                @foreach($component->serials as $serial)
                                    @if(($serial->status == 1 || $serial->status == 2) && $serial->asset_id == $asset->id)
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="serials_list[]" value="{{ $serial->serial_number }}" />
                                                {{ $serial->serial_number }} (<a href="{{ route('hardware.show', $serial->asset->id) }}" class="badge badge-info">{{ $serial->asset->asset_tag }}</a>)
                                            </label>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                        <div class="box-footer">
                            <a class="btn btn-link" href="{{ route('components.index') }}">{{ trans('button.cancel') }}</a>
                            <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.checkin') }}</button>
                        </div>
                    </div> <!-- /.box-->
                </div>
            </form>
        </div> <!-- /.col-md-7-->
    </div>


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
