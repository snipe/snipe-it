<div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="image">{{ trans('general.image_upload') }}</label>
    <div class="col-md-5">
        <label class="btn btn-default">
            {{ trans('button.select_file')  }}
            <input type="file" name="image" id="uploadFile" data-maxsize="{{ \App\Helpers\Helper::file_upload_max_size() }}" accept="image/gif,image/jpeg,image/png,image/svg" style="display:none">
        </label>
        <span class='label label-default' id="upload-file-info"></span>

        <p class="help-block" id="upload-file-status">{{ trans('general.image_filetypes_help', ['size' => \App\Helpers\Helper::file_upload_max_size_readable()]) }}</p>
        {!! $errors->first('image', '<span class="alert-msg">:message</span>') !!}
    </div>
    <div class="col-md-4">
        <img id="imagePreview" style="max-width: 200px;">
    </div>
</div>

