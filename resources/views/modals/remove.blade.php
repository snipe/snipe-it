{{-- See snipeit_modals.js for what powers this --}}
<!-- Remove Location from bulk users -->
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h2 class="modal-title">{{ trans('general.remove_location')  }}</h2>
        </div>
        <div class="modal-body">
            <form action="{{ route('api.users.update', $user->id) }}" onsubmit="return false">
                {{ method_field('PUT') }}
                {{ Form::label('location_id', trans('general.remove_location_msg'))}}
                {{ Form::hidden('location_id', 'test', [$user->id => 'location_id'])}}
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.cancel') }}</button>
            <button type="button" class="btn btn-primary" id="modal-save">{{ trans('general.save') }}</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
