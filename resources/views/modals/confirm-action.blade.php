<!-- Modal -->
<div class="modal fade" id="confirmAction" tabindex="-1" role="dialog" aria-labelledby="confirmActionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="confirmActionLabel">{{ trans('general.file_upload') }}</h4>
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
                        Blah
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
