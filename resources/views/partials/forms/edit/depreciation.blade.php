<!-- Depreciation -->
<div class="form-group {{ $errors->has('depreciation_id') ? ' has-error' : '' }}">
    <label for="depreciation_id" class="col-md-4 col-xs-12">{{ trans('general.depreciation') }}</label>
    <div class="col-md-4 col-xs-12">
        {{ Form::select('depreciation_id', $depreciation_list , old('depreciation_id', $item->depreciation_id), array('class'=>'select2', 'style'=>'width:350px', 'aria-label'=>'depreciation_id')) }}
        {!! $errors->first('depreciation_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
