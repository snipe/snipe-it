<div class="form-group {{ $errors->has((isset($fieldname) ? $fieldname : 'image')) ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="image">{{ trans('general.image_upload') }}</label>
    <div class="col-md-9">

        <input type="file" id="image" name="{{ (isset($fieldname) ? $fieldname : 'image') }}" aria-label="image" class="sr-only">

        <label class="btn btn-default" aria-hidden="true">
            {{ trans('button.select_file')  }}
            <input type="file" name="{{ (isset($fieldname) ? $fieldname : 'image') }}" class="js-uploadFile" id="uploadFile" data-maxsize="{{ Helper::file_upload_max_size() }}" accept="image/gif,image/jpeg,image/webp,image/png,image/svg,image/svg+xml" style="display:none; max-width: 90%" aria-label="image" aria-hidden="true">
        </label>
        <span class='label label-default' id="uploadFile-info"></span>

        <p class="help-block" id="uploadFile-status">{{ trans('general.image_filetypes_help', ['size' => Helper::file_upload_max_size_readable()]) }}</p>
        {!! $errors->first('image', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>
    <div class="col-md-4 col-md-offset-3" aria-hidden="true">
        <img id="uploadFile-imagePreview" style="max-width: 200px; display: none;" alt="{{ trans('partials/forms/general.alt_uploaded_image_thumbnail') }}">
    </div>
</div>

