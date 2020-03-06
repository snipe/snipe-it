<div class="form-group {{ $errors->has((isset($fieldname) ? $fieldname : 'image')) ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="image">{{ trans('general.image_upload') }}</label>
    <div class="col-md-9">
        <label class="btn btn-default">
            {{ trans('button.select_file')  }}
            <input type="file" name="{{ (isset($fieldname) ? $fieldname : 'image')  }}" class="js-uploadFile" id="uploadFile" data-maxsize="{{ \App\Helpers\Helper::file_upload_max_size() }}" accept="image/gif,image/jpeg,image/png,image/svg,image/svg+xml,image/bmp" style="display:none; max-width: 90%">
        </label>
        <span class='label label-default' id="uploadFile-info"></span>

        <p class="help-block" id="uploadFile-status">{{ trans('general.image_filetypes_help', ['size' => \App\Helpers\Helper::file_upload_max_size_readable()]) }}</p>
        {!! $errors->first('image', '<span class="alert-msg">:message</span>') !!}
    </div>
    <div class="col-md-9 col-md-offset-3">
        <img id="uploadFile-imagePreview" style="max-width: 200px;">
    </div>
</div>

