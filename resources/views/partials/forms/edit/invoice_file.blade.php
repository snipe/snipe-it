<div class="form-group {{ $errors->has('invoice_file') ? 'has-error' : '' }}">
    <label class="col-md-3 control-label" for="invoice_file">Загрузить счет</label>
    <div class="col-md-9">

        <input type="file" id="invoice_file" name="invoice_file" aria-label="invoice_file" class="sr-only">

        <label class="btn btn-default" aria-hidden="true">
            {{ trans('button.select_file')  }}
            <input type="file" name="invoice_file" id="uploadFile" data-maxsize="{{ \App\Helpers\Helper::file_upload_max_size() }}" accept="application/pdf,application/x-pdf,application/x-bzpdf,application/x-gzpdf" style="display:none" aria-label="image" aria-hidden="true">
        </label>
        <span class='label label-default' id="upload-file-info"></span>

        <p class="help-block" id="upload-file-status">Приемлемые типы файлов: pdf. Максимальный размер загружаемого файла 8M.</p>
        {!! $errors->first('image', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
    </div>
</div>

