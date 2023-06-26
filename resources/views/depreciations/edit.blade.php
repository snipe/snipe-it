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

<!-- Term -->
<div class="form-group {{ $errors->has('term_length') ? ' has-error' : '' }}">
    <label for="term" class="col-md-3 control-label">
        {{ trans('admin/depreciations/general.term_length') }}
    </label>
    <div class="col-md-7 col-sm-12 {{  (Helper::checkIfRequired($item, 'term_length')) ? ' required' : '' }}">
        <div class="col-md-7" style="padding-left:0px;">
            <input class="form-control" type="text" name="term_length" id="term_length" value="{{ Request::old('term_length', $item->term_length) }}" style="width: 80px;display:inline-block;"{!!  (\App\Helpers\Helper::checkIfRequired($item, 'term_length')) ? ' data-validation="required" required' : '' !!} />
            {!! $errors->first('term_length', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
                <select class="select2" name="term_type" id="term_type" value="{{ Request::old('term_type', $item->term_type) }}"style="width:130px;display:inline-block;">
                    <option value="months" @if ($item->term_type = old($item->term_type,  (isset($item)) ? 'selected="selected"' : ''))@endif>Months</option>
                    <option value="days" @if ($item->term_type = old($item->term_type,  (isset($item)) ? 'selected="selected"' : ''))@endif>Days</option>

                </select>

        </div>
    </div>
</div>

<!-- Depreciation Minimum -->
<div class="form-group {{ $errors->has('depreciation_min') ? ' has-error' : '' }}">
    <label for="depreciation_min" class="col-md-3 control-label">
        {{ trans('admin/depreciations/general.depreciation_min') }}
    </label>
    <div class="col-md-2" style="padding-left:0px">
        <input class="form-control"  name="depreciation_min" id="depreciation_min" value="{{ Request::old('depreciation_min', $item->depreciation_min) }}" style="width: 80px; margin-left:15px" />
    </div>
    {!! $errors->first('depreciation_min', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
</div>
@stop
