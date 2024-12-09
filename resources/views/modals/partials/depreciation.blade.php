<!-- partials/modals/partials/depreciation.blade.php -->
<div class="dynamic-form-row">
    <div class="col-md-4">
        <label for="modal-depreciation_id">{{ trans('general.depreciation') }}:</label>
    </div>
    <div class="col-md-8 ">
        {{ Form::select('depreciation_id', $depreciation_list, old('depreciation_id', $item->depreciation_id), [
            'class' => 'js-data-ajax select2',
            'data-endpoint' => 'depreciations',
            'style' => 'width: 100%',
            'id' => 'modal-depreciation_id',
            'aria-label' => 'depreciation_id',
        ]) }}
        {!! $errors->first('depreciation_id', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
<!-- partials/modals/partials/depreciation.blade.php -->