<!-- partials/modals/partials/depreciation.blade.php -->
<div class="dynamic-form-row">
    <div class="col-md-4 col-xs-12">
        <label for="modal-depreciation_id">{{ trans('general.depreciation') }}</label>
    </div>
    <div class="col-md-8 col-xs-12">
        {{ Form::select('depreciation_id', $depreciation_list , old('depreciation_id', $item->depreciation_id), array('class'=>'select2', 'style'=>'width:100%;', 'aria-label'=>'depreciation_id')) }}
        {!! $errors->first('depreciation_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
<!-- partials/modals/partials/depreciation.blade.php -->