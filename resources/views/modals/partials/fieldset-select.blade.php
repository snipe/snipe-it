<!-- partials/modals/partials/fieldset-select.blade.php -->
<div class="dynamic-form-row">
    <div class="col-md-4 col-xs-12"><label for="modal-fieldset_id">{{ trans('admin/models/general.fieldset') }}:</label></div>
    <div class="col-md-8 col-xs-12">{{ Form::select('fieldset_id', Helper::customFieldsetList(),old('fieldset_id'), array('class'=>'select2', 'id'=>'modal-fieldset_id', 'style'=>'width:100%;')) }}</div>
</div>
<!-- partials/modals/partials/fieldset-select.blade.php -->