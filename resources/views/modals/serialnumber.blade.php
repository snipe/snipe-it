{{-- See snipeit_modals.js for what powers this --}}
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <h2 class="modal-title">Serial Number Required for: {{ request('result') }}</h2>
        </div>
        <div class="modal-body">
            <form action="{{ route('productflow.receiving.store') }}" >
                {{ csrf_field() }}
                <div class="alert alert-danger" id="modal_error_msg" style="display:none">
                </div>

                <div class="dynamic-form-row">
                    <div class="col-md-4 col-xs-12"><label for="modal-serial_number">Serial Number</label></div>
                    <div class="col-md-8 col-xs-12"><input type='text' name="serialnumber" id='modal-serial_number' class="form-control"></div>
                </div>
                <input type="text" value="{{ request('result') }}" id="modal-model" name="model" hidden="true">
            </form>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.cancel') }}</button>
            <button type="button" class="btn btn-primary" id="modal-save">{{ trans('general.save') }}</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->