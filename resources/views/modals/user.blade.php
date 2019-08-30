{{-- See snipeit_modals.js for what powers this --}}
<script src="/js/pGenerator.jquery.js"></script>

<script nonce="{{ csrf_token() }}">
    $(document).ready(function () {

        $('#genPassword').pGenerator({
            'bind': 'click',
            'passwordElement': '#modal-password',
            'displayElement': '#generated-password',
            'passwordLength': 16,
            'uppercase': true,
            'lowercase': true,
            'numbers': true,
            'specialChars': true,
            'onPasswordGenerated': function (generatedPassword) {
                $('#modal-password_confirmation').val($('#modal-password').val());
            }
        });
    });
</script>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">{{ trans('admin/users/table.createuser') }}</h4>
        </div>
            <div class="modal-body">
                <form action="{{ route('api.users.store') }}" onsubmit="return false">
                    <div class="alert alert-danger" id="modal_error_msg" style="display:none">
                    </div>
                    <div class="dynamic-form-row">
                        <div class="col-md-4 col-xs-12"><label for="modal-first_name">{{ trans('general.first_name') }}:</label></div>
                        <div class="col-md-8 col-xs-12 required"><input type='text' name="first_name" id='modal-first_name' class="form-control"></div>
                    </div>

                    <div class="dynamic-form-row">
                        <div class="col-md-4 col-xs-12"><label for="modal-last_name">{{ trans('general.last_name') }}:</label></div>
                        <div class="col-md-8 col-xs-12"><input type='text' name="last_name" id='modal-last_name' class="form-control"> </div>
                    </div>

                    <div class="dynamic-form-row">
                        <div class="col-md-4 col-xs-12"><label for="modal-username">{{ trans('admin/users/table.username') }}:</label></div>
                        <div class="col-md-8 col-xs-12 required"><input type='text' name="username" id='modal-username' class="form-control"></div>
                    </div>

                    <div class="dynamic-form-row">
                        <div class="col-md-4 col-xs-12"><label for="modal-password">{{ trans('admin/users/table.password') }}:</label></div>
                        <div class="col-md-8 col-xs-12 required"><input type='password' name="password" id='modal-password' class="form-control">
                            <a href="#" class="left" id="genPassword">Generate</a>
                        </div>
                    </div>

                    <div class="dynamic-form-row">
                        <div class="col-md-4 col-xs-12"><label for="modal-password_confirmation">{{ trans('admin/users/table.password_confirm') }}:</label></div>
                        <div class="col-md-8 col-xs-12 required"><input type='password' name="password_confirmation" id='modal-password_confirmation' class="form-control">
                            <div id="generated-password"></div>
                        </div>
                    </div>
                </form>
            </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('button.cancel') }}</button>
            <button type="button" class="btn btn-primary" id="modal-save">{{ trans('general.save') }}</button>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
