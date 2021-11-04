<!-- Classified By -->
<div class="form-group {{ $errors->has('classified_by') ? ' has-error' : '' }}">
    <label for="classified_by" class="col-md-3 control-label">Classified By</label>
    <div class="col-md-7">
    <input class="form-control" type="text" name="classified_by" aria-label="classified_by" id="classified_by" value="{{ old('classified_by', $item->classifiedBy) }}" />
        {!! $errors->first('classified_by', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>