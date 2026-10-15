<div class="modal fade modal-danger" id="confirmImpersonateModal" tabindex="-1" role="dialog" aria-labelledby="confirmImpersonateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="confirmImpersonateModalLabel">{{ trans('admin/users/general.impersonate_confirm_title') }}</h4>
            </div>
            <form action="{{ route('users.impersonate.start', $user->id) }}" method="POST" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {{ trans('admin/users/general.impersonate_confirm_body', ['name' => $user->display_name]) }}
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-12">
                            <label for="impersonate_note" class="control-label" style="color: #ffffff;">
                                {{ trans('admin/users/general.impersonate_note_label') }} <span aria-hidden="true">*</span>
                            </label>
                            <textarea
                                name="note"
                                id="impersonate_note"
                                class="form-control"
                                rows="3"
                                maxlength="500"
                                required
                                aria-required="true"
                                placeholder="{{ trans('admin/users/general.impersonate_note_placeholder') }}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">{{ trans('button.cancel') }}</button>
                    <button type="submit" class="btn btn-outline">{{ trans('general.yes') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
