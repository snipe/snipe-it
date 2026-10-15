@props(['itemType', 'itemId'])

<x-modals
    id="uploadFileModal"
    stacked
    :title="trans('general.file_upload')"
    :action="route('ui.files.store', ['object_type' => str_plural($itemType), 'id' => $itemId])"
    :submit_label="trans('button.upload')"
    submit_class="btn-theme"
    form_attrs='accept-charset="UTF-8" enctype="multipart/form-data"'
>
    <div class="row">
        <div class="col-md-12">
            <label class="btn btn-theme btn-block">
                {{ trans('button.select_files') }}
                <input
                    type="file"
                    name="file[]"
                    multiple
                    class="js-uploadFile"
                    id="uploadFile"
                    data-maxsize="{{ Helper::file_upload_max_size() }}"
                    accept="{{ config('filesystems.allowed_upload_mimetypes') }}"
                    style="display:none"
                    required
                >
            </label>
        </div>
        <div class="col-md-12">
            <span id="uploadFile-info"></span>
        </div>
        <div class="col-md-12">
            <x-form.help name="uploadFile">
                {{ trans('general.upload_filetypes_help', ['allowed_filetypes' => config('filesystems.allowed_upload_extensions'), 'size' => Helper::file_upload_max_size_readable()]) }}
            </x-form.help>
        </div>
        <div class="col-md-12">
            <x-input.textarea
                name="notes"
                :value="old('notes')"
                placeholder="{{ trans('general.notes') }}"
                rows="3"
                aria-label="{{ trans('general.notes') }}"
            />
        </div>
    </div>
</x-modals>
