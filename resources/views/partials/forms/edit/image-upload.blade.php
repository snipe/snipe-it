<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="image">{{ trans('general.image_upload') }}</label>
    <div class="col-md-5">
        <label class="btn btn-default">
            {{ trans('button.select_file')  }}
            <input type="file" name="image" accept="image/gif,image/jpeg,image/png,image/svg" hidden>
        </label>
        <p class="help-block">{{ trans('general.image_filetypes_help') }}</p>
        {!! $errors->first('image', '<span class="alert-msg">:message</span>') !!}
    </div>
</div>
