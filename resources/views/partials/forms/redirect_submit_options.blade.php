<!-- begin redirect submit options -->

<div class="box-footer">
    <div class="row">

        <div class="col-md-3">
            <a class="btn btn-link" href="{{ route($route) }}">{{ trans('button.cancel') }}</a>
        </div>

        <div class="col-md-9 text-right">
            <div class="btn-group text-left">

                <select class="redirect-options form-control select2" data-minimum-results-for-search="Infinity" name="redirect_option" style="min-width: 200px"{{ (!$asset->model ? ' disabled' : '') }}>

                    <option {{ (Session::get('redirect_option')=="0" || (Session::get('redirect_option')=="2" && $checkin)) ? 'selected' : '' }} value="0">
                        {{ trans('admin/hardware/form.redirect_to_all', ['type' => $table_name]) }}
                    </option>
                    <option {{ Session::get('redirect_option')=="1" ? 'selected' : ''}} value="1">
                        {{ trans('admin/hardware/form.redirect_to_type', ['type' => $type]) }}
                    </option>
                    <option {{ Session::get('redirect_option')=="2" && !$checkin ? 'selected' : ''}}{{ $checkin ? 'hidden disabled' : '' }} value="2" >
                        {{ !$checkin ? trans('admin/hardware/form.redirect_to_checked_out_to') : '' }}
                    </option>

                </select>

                <button type="submit" class="btn btn-primary pull-right{{ (!$asset->model ? ' disabled' : '') }}" style="margin-left:5px; border-radius: 3px;"{!! (!$asset->model ? ' data-tooltip="true" title="'.trans('admin/hardware/general.edit').'" disabled' : '') !!}>
                    <i class="fas fa-check icon-white" aria-hidden="true"></i>
                    {{ $checkin ? trans('general.checkin') : trans('general.checkout') }}
                </button>

            </div><!-- /.btn-group -->
        </div><!-- /.col-md-9 -->
    </div><!-- /.row -->
</div> <!-- /.box-footer -->
<!-- end redirect submit options -->