<!-- Derived From -->
<div class="form-group {{ $errors->has('derived_from') ? ' has-error' : '' }}">
    <label for="derived_from" class="col-md-3 control-label">Derived From</label>
    <div class="col-md-7">
    <input class="form-control" type="text" name="derived_from" aria-label="derived_from" id="derived_from" value="{{ old('derived_from', $item->classifiedBy) }}" />
        {!! $errors->first('derived_from', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>