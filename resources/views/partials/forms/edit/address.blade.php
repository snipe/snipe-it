<div class="form-group {{ $errors->has('address') ? ' has-error' : '' }}">
    <label for="address" class="col-md-3 control-label">{{ trans('general.address') }}</label>
    <div class="col-md-7">
        <input class="form-control" aria-label="address" maxlength="191" name="address" type="text" id="address" value="{{ old('address', $item->address) }}">
        <x-form.error name="address" />
    </div>
</div>

<div class="form-group {{ $errors->has('address2') ? ' has-error' : '' }}">
    <label class="sr-only " for="address2">{{  trans('general.address')  }}</label>
    <div class="col-md-7 col-md-offset-3">
        <input class="form-control" aria-label="address2" maxlength="191" name="address2" type="text" value="{{ old('address2', $item->address2) }}">
        <x-form.error name="address2" />
    </div>
</div>

<div class="form-group {{ $errors->has('city') ? ' has-error' : '' }}">
    <label for="city" class="col-md-3 control-label">{{ trans('general.city') }}</label>
    <div class="col-md-7">
        <input class="form-control" aria-label="city" maxlength="191" name="city" type="text" id="city" value="{{ old('city', $item->city) }}">
        <x-form.error name="city" />
    </div>
</div>

<div class="form-group {{ $errors->has('state') ? ' has-error' : '' }}">
    <label for="state" class="col-md-3 control-label">{{ trans('general.state') }}</label>
    <div class="col-md-7">
        <input class="form-control" aria-label="state" maxlength="191" name="state" type="text" id="state" value="{{ old('state', $item->state) }}">
        <x-form.error name="state" />

    </div>
</div>

<div class="form-group {{ $errors->has('country') ? ' has-error' : '' }}">
    <label for="country" class="col-md-3 control-label">{{ trans('general.country') }}</label>
    <div class="col-md-7">
        <x-input.country-select
            name="country"
            :selected="old('country', $item->country)"
        />
        <p class="help-block">{{ trans('general.countries_manually_entered_help') }}</p>
        <x-form.error name="country" />
    </div>
</div>

<div class="form-group {{ $errors->has('zip') ? ' has-error' : '' }}">
    <label for="zip" class="col-md-3 control-label">{{ trans('general.zip') }}</label>
    <div class="col-md-3">
        <input class="form-control" name="zip" type="text" id="zip" value="{{ old('zip', $item->zip) }}" maxlength="10" aria-label="zip">
        <x-form.error name="zip" />
    </div>
</div>
