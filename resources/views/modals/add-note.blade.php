{{-- See snipeit_modals.js for what powers this --}}
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title">{{ trans('general.add_note')  }}</h2>
        </div>

        <div class="modal-body">
            <form action="{{ route('api.notes.store') }}" onsubmit="return false">
                <input type="hidden" name="type" value="{{request("type")}}"/>
                <input type="hidden" name="id" value="{{request("id")}}"/>
                <div class="alert alert-danger" id="modal_error_msg" style="display:none"></div>

                <div class="row">
                    <div class="col-md-12">
                        <textarea class="form-control" id="note" name="note">{{ old('note') }}</textarea>
                        {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fas fa-times" aria-hidden="true"></i> :message</span>') !!}
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('button.cancel') }}</button>
            <button type="button" class="btn btn-primary pull-right" id="modal-save">{{ trans('general.save') }}</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->