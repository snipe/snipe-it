<!-- comment -->
<div class="form-group {{ $errors->has('comment') ? ' has-error' : '' }}">
    <label for="comment" class="col-md-3 control-label">{{ $translated_name }}</label>
    <div class="col-md-7 col-sm-12">
        <textarea class="col-md-6 form-control" id="comment" aria-label="comment" name="comment">{{ Input::old('notes', $item->comment) }}</textarea>
        {!! $errors->first('comment', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
    </div>
</div>
