@extends('layouts/edit-form', [
    'createText' => trans('admin/depreciations/general.create') ,
    'updateText' => trans('admin/depreciations/general.update'),
    'helpPosition'  => 'right',
    'helpText' => trans('help.depreciations'),
    'formAction' => (isset($item->id)) ? route('depreciations.update', ['depreciation' => $item->id]) : route('depreciations.store'),
])

{{-- Page content --}}
@section('inputFields')

@include ('partials.forms.edit.name', ['translated_name' => trans('admin/depreciations/general.depreciation_name')])
<!-- Months -->
<div class="form-group {{ $errors->has('months') ? ' has-error' : '' }}">
    <label for="months" class="col-md-3 control-label">
        {{ trans('admin/depreciations/general.number_of_months') }}
    </label>
    <div class="col-md-7{{  (\App\Helpers\Helper::checkIfRequired($item, 'months')) ? ' required' : '' }}">
        <div class="col-md-2" style="padding-left:0px">
            <input class="form-control" type="text" name="months" id="months" value="{{ Request::old('months', $item->months) }}" style="width: 80px;" />
        </div>
    </div>
    {!! $errors->first('months', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
</div>
<!-- Min Depreciation -->
    <label for="min-value" class="col-md-3 control-label">
        {{ trans('admin/depreciations/general.min-value') }}
    </label>
        <div class="col-md-2" style="padding-left:0px">
            <input class="form-control" type="number" step="0.01" min="0.00" name="min-value" id="min-value" value="{{ Request::old('min_value', $item->min_value) }}" style="width: 80px;" />
        </div>
    </div>
    {!! $errors->first('min-value', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
</div>

@stop
