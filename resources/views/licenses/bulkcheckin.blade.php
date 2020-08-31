@extends('layouts/default')

{{-- Page title --}}
@section('title')
     {{ trans('admin/licenses/general.checkin') }}
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
            <form class="form-horizontal" method="post" action="{{ route('licenses.bulkcheckin.save', ['licenseId'=>$license->id, 'backTo'=>$backto] ) }}" autocomplete="off">
                {{csrf_field()}}

                <div class="box box-default">
                    <div class="box-header with-border">
                        <h2 class="box-title"> {{ $license->name }}</h2>
                    </div>
                    <div class="box-body">

            <!-- license name -->
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin/hardware/form.name') }}</label>
                <div class="col-md-6">
                    <p class="form-control-static">{{ $license->name }}</p>
                </div>
            </div>

            <!-- Serial -->
            <div class="form-group">
                <label class="col-sm-2 control-label">{{ trans('admin/hardware/form.serial') }}</label>
                <div class="col-md-6">
                    <p class="form-control-static">
                        @can('viewKeys', $license)
                            {{ $license->serial }}
                        @else
                            ------------
                        @endcan
                        </p>
                </div>
            </div>
            @if ($user == null && $asset == null)
                @include ('partials.forms.checkout-selector', ['user_select' => 'true','asset_select' => 'true', 'location_select' => 'false'])

                @include ('partials.forms.edit.user-select-custom-endpoint', ['translated_name' => trans('general.user'), 'fieldname' => 'assigned_to', 'user_select_data_endpoint' => 'licenses/assignedUsers/' . $license->id ])

                @include ('partials.forms.edit.asset-select-custom-endpoint', ['translated_name' => trans('admin/licenses/form.asset'), 'fieldname' => 'asset_id', 'style' => 'display:none;', 'asset_select_data_endpoint' => 'licenses/assignedAssets/' . $license->id])
            @endif

            <!-- QTY -->
            <div class="form-group {{ $errors->has('qty') ? ' has-error' : '' }}">
                <label for="qty" class="col-md-3 control-label">{{ trans('general.quantity') }}</label>
                <div class="col-md-7">
                   <div class="col-md-2" style="padding-left:0px">
                       <input class="form-control" type="number" name="qty" aria-label="qty" id="qty" value="{{ old('qty', 1) }}" min="1" step="1" />
                   </div>
                   {!! $errors->first('qty', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
                </div>
            </div>


            <!-- Note -->
            <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">
                <label for="note" class="col-md-2 control-label">{{ trans('admin/hardware/form.notes') }}</label>
                <div class="col-md-7">
                    <textarea class="col-md-6 form-control" id="note" name="note">{{ old('note') }}</textarea>
                    {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
                </div>
            </div>
                        <div class="box-footer">
                            <a class="btn btn-link" href="{{ route('licenses.index') }}">{{ trans('button.cancel') }}</a>
                            <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check icon-white" aria-hidden="true"></i> {{ trans('general.checkin') }}</button>
                        </div>
                    </div> <!-- /.box-->
            </form>
        </div> <!-- /.col-md-7-->
    </div>


@stop
