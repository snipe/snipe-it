<!-- Modal -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" role="dialog" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="uploadFileModalLabel">{{ trans('general.file_upload') }}</h4>
            </div>
            {{ Form::open([
            'method' => 'POST',
            'route' => ['upload/'.$item_type, $item_id],
            'files' => true,
            'class' => 'form-horizontal' ]) }}
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="modal-body">

                <div class="row">
                    <div class="col-md-12">

                        <label class="btn btn-default btn-block">
                            {{ trans('button.select_files')  }}
                            <input type="file" name="file[]" multiple="true" class="js-uploadFile" id="uploadFile" data-maxsize="{{ Helper::file_upload_max_size() }}" accept="image/*,.csv,.zip,.rar,.doc,.docx,.xls,.xlsx,.xml,.lic,.xlsx,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,text/plain,.pdf,application/rtf,application/json" style="display:none" required>
                        </label>

                    </div>
                    <div class="col-md-12">
                        <span id="uploadFile-info"></span>
                    </div>
                    <div class="col-md-12">
                        <p class="help-block" id="uploadFile-status">{{ trans('general.upload_filetypes_help', ['size' => Helper::file_upload_max_size_readable()]) }}</p>
                    </div>

                    <div class="col-md-12">
                        <x-input.textarea
                            name="notes"
                            :value="old('notes')"
                            placeholder="Notes (Optional)"
                            rows="3"
                            aria-label="file"
                        />
                    </div>
                </div>

            </div> <!-- /.modal-body-->
            <div class="modal-footer">
                <a href="#" class="pull-left" data-dismiss="modal">{{ trans('button.cancel') }}</a>
                <button type="submit" class="btn btn-primary">{{ trans('button.upload') }}</button>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
