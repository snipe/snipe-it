<!-- Name -->
<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="col-md-3 control-label">{{ $translated_name }}</label>
    <div class="col-md-8 col-sm-12">
        <input class="form-control" style="width:100%;" type="text" name="name" aria-label="name" id="name" value="{{ old('name', $item->name) }}"{!!  (Helper::checkIfRequired($item, 'name')) ? ' required' : '' !!} maxlength="191" />
        <x-form.error name="name" />
    </div>
</div>
