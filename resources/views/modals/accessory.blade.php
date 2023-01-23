<div id="accessoryQTY" class="modal fade">
    <div class="modal-dialog">
        <form id="accessory-form" method="post" action="{{ route('productflow.receiving.update') }}">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h2 class="modal-title text-center">Enter Amount Received for: </h2>
                    <h3 class="modal-title text-center" id="accessory-info"><span></span></h3>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="alert alert-danger" id="accessory_modal_error_msg" style="display:none"></div>
                    <div class="dynamic-form-row text-center" id="model-info"><span></span></div>
                    <div class="dynamic-form-row">
                        <div class="col-md-4 col-xs-12"><label for="modal-accessory_qty">QTY</label></div>
                        <div class="col-md-7 required">
                            <input type='text' name="accessory_qty" id='modal-accessory_qty' class="form-control"
                                data-validation="required">
                        </div>
                    </div>
                    <input type="text" id="accessory-id" name="accessory_id" hidden="true">
                    <input type="text" id="accessory-model_number" name="accessory_model_number" hidden="true">
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