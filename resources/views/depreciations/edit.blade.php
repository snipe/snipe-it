@extends('layouts/edit-form', [
    'createText' => trans('admin/depreciations/general.create') ,
    'updateText' => trans('admin/depreciations/general.update'),
    'helpTitle' => trans('admin/depreciations/general.about_asset_depreciations'),
    'helpText' => trans('admin/depreciations/general.about_depreciations'),
    'formAction' => ($item) ? route('depreciations.update', ['depreciation' => $item->id]) : route('depreciations.store'),
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
            <input class="form-control" type="text" name="months" id="months" value="{{ Input::old('months', $item->months) }}" style="width: 80px;" />
        </div>
    </div>
    {!! $errors->first('months', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
</div>

@stop
