<div id="buttonDropdown" class="modal fade">
    <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h2 class="modal-title text-center">Create a new Asset or Accessory</h2>
                    
                </div>
                <div class="modal-body">
                    <div class="col-md-12 col-sm-12 text-center">
                        <a href='{{ route('modal.show', 'model') }}' data-toggle="modal" data-target="#createModal"
                            data-select='model_select_id'
                            class="btn btn-sm btn-primary" id="newAsset">New Asset Model</a>
                            <a href='{{ route('accessories.create') }}' data-toggle="modal" 
                            class="btn btn-sm btn-primary">New Accessory</a>
                    </div>
                                       
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                        data-dismiss="modal">{{ trans('button.cancel') }}</button>
                </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>