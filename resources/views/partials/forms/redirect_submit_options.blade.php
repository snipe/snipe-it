<div class="box-footer">
    <a class="btn btn-link" href="{{ route($route) }}">{{ trans('button.cancel') }}</a>
    <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-check icon-white" aria-hidden="true"></i> {{ trans('general.checkout') }}</button>
        <div class="btn-group pull-right" style="margin-right:5px;">
            <select class="redirect-options form-control" name="redirect_option">
                <option {{Session::get('redirect_option')=="0" ? 'selected' : ''}} value="0">{{trans('admin/hardware/form.redirect_to_all', ['type' => $table_name])}}</option>
                <option {{Session::get('redirect_option')=="1" ? 'selected' : ''}} value="1">{{trans('admin/hardware/form.redirect_to_type', ['type' => $type])}}</option>
                <option {{Session::get('redirect_option')=="2" ? 'selected' : ''}} value="2" {{$checkin ? 'hidden' : ''}}>{{trans('admin/hardware/form.redirect_to_checked_out_to')}}</option>
            </select>
        </div>
</div> <!-- /.box-->