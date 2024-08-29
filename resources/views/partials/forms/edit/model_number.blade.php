<!-- Model Number -->
<div class="form-group {{ $errors->has('model_number') ? ' has-error' : '' }}">
    <label for="model_number" class="col-md-3 control-label">{{ trans('general.model_no') }}</label>
    <div class="col-md-7">
    <input class="form-control" type="text" name="model_number" aria-label="model_number" id="model_number" value="{{ old('model_number', $item->model_number) }}" />
        <x-form-error name="model_number" />
    </div>
</div>
