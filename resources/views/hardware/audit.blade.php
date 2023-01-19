@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.audit') }}
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
        <div class="col-md-7">
            <div class="box box-default">

                {{ Form::open([
                  'method' => 'POST',
                  'route' => ['asset.audit.store', $asset->id],
                  'files' => true,
                  'class' => 'form-horizontal' ]) }}

                    <div class="box-header with-border">
                        <h2 class="box-title"> {{ trans('admin/hardware/form.tag') }} {{ $asset->asset_tag }}</h2>
                    </div>
                    <div class="box-body">
                    {{csrf_field()}}
                    @if ($asset->model->name)
                        <!-- Asset name -->
                            <div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
                                {{ Form::label('name', trans('admin/hardware/form.model'), array('class' => 'col-md-3 control-label')) }}
                                <div class="col-md-8">
                                    <p class="form-control-static">{{ $asset->model->name }}</p>
                                </div>
                            </div>
                    @endif

                    <!-- Asset Name -->
                        <div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
                            {{ Form::label('name', trans('admin/hardware/form.name'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-8">
                                <p class="form-control-static">{{ $asset->name }}</p>
                            </div>
                        </div>

                        <!-- Locations -->
                    @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id'])

                    <!-- Update location -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-md-9">
                                <label>
                                    <input type="checkbox" value="1" name="update_location" class="minimal" {{ Request::old('update_location') == '1' ? ' checked="checked"' : '' }}> {{ trans('admin/hardware/form.asset_location') }}
                                </label>

                                @include ('partials.more-info', ['helpText' => trans('help.audit_help'), 'helpPosition' => 'right'])



                            </div>
                        </div>


                        <!-- Next Audit -->
                        <div class="form-group {{ $errors->has('next_audit_date') ? 'error' : '' }}">
                            {{ Form::label('name', trans('general.next_audit_date'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-9">
                                <div class="input-group date col-md-5" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-clear-btn="true">
                                    <input type="text" class="form-control" placeholder="{{ trans('general.next_audit_date') }}" name="next_audit_date" id="next_audit_date" value="{{ old('next_audit_date', $next_audit_date) }}">
                                    <span class="input-group-addon"><i class="fas fa-calendar" aria-hidden="true"></i></span>
                                </div>
                                {!! $errors->first('next_audit_date', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>


                        <!-- Note -->
                        <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                            {{ Form::label('note', trans('admin/hardware/form.notes'), array('class' => 'col-md-3 control-label')) }}
                            <div class="col-md-8">
                                <textarea class="col-md-6 form-control" id="note" name="note">{{ old('note', $asset->note) }}</textarea>
                                {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                            </div>
                        </div>


                        <!-- Images -->
                        @include ('partials.forms.edit.image-upload')






                    </div> <!--/.box-body-->
                    <div class="box-footer">
                        <a class="btn btn-link" href="{{ URL::previous() }}"> {{ trans('button.cancel') }}</a>
                        <button type="submit" class="btn btn-success pull-right"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.audit') }}</button>
                    </div>
                </form>
            </div>
        </div> <!--/.col-md-7-->
    </div>
@stop
