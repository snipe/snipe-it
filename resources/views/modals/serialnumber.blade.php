<div id="getSerial" class="modal fade">
    <div class="modal-dialog">
        <form id="serial-number-form" method="post" action="{{ route('productflow.receiving.store') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h2 class="modal-title text-center">Serial Number Required for: </h2>
                    <h3 class="modal-title text-center" id="model-info"><span></span></h3>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="alert alert-danger" id="modal_error_msg" style="display:none"></div>
                    <div class="dynamic-form-row text-center" id="model-info"><span></span></div>
                    <div class="dynamic-form-row">
                        <div class="col-md-4 col-xs-12"><label for="modal-serial_number">Serial Number</label></div>
                        <div class="col-md-7 required">
                            <input type="text" name="asset_tag" id="asset_tag"
                                value="{{ \App\Models\Asset::autoincrement_asset() }}" hidden="true">

                            <input type='text' name="serial_number" id='modal-serial_number' class="form-control"
                                data-validation="required">
                        </div>
                    </div>
                    <input type="text" id="modelID" name="model_id" hidden="true">
                    <input type="text" id="model_number" name="model_number" hidden="true">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                        data-dismiss="modal">{{ trans('button.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('general.save') }}</button>
                </div>
        </form>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>